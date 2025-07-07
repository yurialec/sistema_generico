<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar logotipo</h5>
            </div>

            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>

            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="logo.name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" @change="loadImage">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexLogo" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        urlIndexLogo: String,
    },
    data() {
        return {
            loading: false,
            logo: {
                name: '',
                imageFile: null,
            },
        };
    },
    methods: {
        loadImage(event) {
            const file = event.target.files[0];
            this.logo.imageFile = file ? file : null;
        },
        save() {
            const formData = new FormData();
            formData.append('name', this.logo.name);
            if (this.logo.imageFile) {
                formData.append('image', this.logo.imageFile);
            }

            this.loading = true;

            axios.post('/admin/site/logo/store', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(() => {
                this.alertSuccess('Operação realizada com sucesso!');
                window.location.href = this.urlIndexLogo;
            }).catch(error => {
                this.alertDanger(error?.response?.data?.message || 'Erro ao cadastrar logotipo.');
            }).finally(() => {
                this.loading = false;
            });
        },
    }
}
</script>
