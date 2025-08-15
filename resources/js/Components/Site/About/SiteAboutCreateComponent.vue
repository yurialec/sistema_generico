<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Sobre</h5>
            </div>
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save">
                            <div class="mb-3">
                                <input type="file" required class="form-control mb-3" @change="loadImage">
                                <img v-if="urlImage" class="form-control h-50 w-50 mb-3  mx-auto d-block" :src="urlImage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" maxlength="255" class="form-control" v-model="about.title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea maxlength="1000" class="form-control" rows="5"
                                    v-model="about.description"></textarea>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexAbout" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexAbout: String,
    },
    data() {
        return {
            loading: false,
            about: {
                title: '',
                description: '',
                image: null,
            },
            urlImage: null,
        };
    },
    methods: {
        loadImage(e) {
            this.about.image = e.target.files[0];
            this.urlImage = URL.createObjectURL(this.about.image);
        },
        save() {
            let formData = new FormData();

            if (this.about.image) {
                formData.append('image', this.about.image);
            }

            if (this.about.title) {
                formData.append('title', this.about.title);
            }

            if (this.about.description) {
                formData.append('description', this.about.description);
            }

            this.loading = true;
            axios.post('/admin/site/site-about/store', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(response => {
                this.alertSuccess('Operação realizada com sucesso!');
            }).catch(errors => {
                this.alertDanger(errors);
            }).finally(() => {
                this.loading = false;
            });
        },
    }
}
</script>
