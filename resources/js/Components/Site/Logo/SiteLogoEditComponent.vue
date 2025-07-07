<template>
    <div class="card">
        <div class="card-header">
            <h4>Editar Logo</h4>
        </div>
        <div v-if="loading" class="d-flex justify-content-center py-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
        <div v-else class="card-body">
            <div class="d-flex justify-content-center">
                <form method="POST" @submit.prevent="save()" class="col-lg-6" autocomplete="off">
                    <div class="form-group mb-3">
                        <label>Nome</label>
                        <input type="text" class="form-control" v-model="logo.name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Imagem</label>
                        <input type="file" class="form-control" @change="loadImage">
                        <div v-if="logo.imageUrl" class="mt-2">
                            <img :src="logo.imageUrl" alt="Logo atual" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-6 text-start">
                            <a :href="urlIndexLogo" class="btn btn-secondary btn-sm">Voltar</a>
                        </div>
                        <div class="col-sm-6 text-end">
                            <button class="btn btn-primary btn-sm" type="submit">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        urlIndexLogo: String,
        id: String,
    },
    data() {
        return {
            loading: false,
            logo: {
                name: '',
                image: '',
                imageFile: null,
                imageUrl: '',
            },
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/site/logo/find/' + this.id)
                .then(response => {
                    const data = response.data.logo;
                    this.logo.name = data.name;
                    this.logo.image = data.image;
                    this.logo.imageUrl = data.imageUrl;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.logo.imageFile = file;

                const reader = new FileReader();
                reader.onload = e => {
                    this.logo.imageUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        save() {
            const formData = new FormData();
            formData.append('name', this.logo.name);
            if (this.logo.imageFile) {
                formData.append('image', this.logo.imageFile);
            }

            this.loading = true;

            axios.post('/admin/site/logo/update/' + this.id, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(() => {
                this.alertSuccess('Logo atualizada com sucesso!');
                window.location.href = this.urlIndexLogo;
            }).catch(error => {
                this.alertDanger(error?.response?.data?.message || 'Erro ao atualizar logotipo.');
            }).finally(() => {
                this.loading = false;
            });
        },
    }
}
</script>
