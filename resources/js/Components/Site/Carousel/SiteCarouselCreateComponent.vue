<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Carousel</h5>
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
                                <label class="form-label">Imagem</label>
                                <input type="file" required class="form-control" @change="loadImage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" v-model="carousel.title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto</label>
                                <textarea class="form-control" v-model="carousel.description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nome Link Externo</label>
                                <input type="text" class="form-control" v-model="carousel.name_link">
                                <small v-show="carousel.url_link.length && !carousel.name_link" style="color: red;">
                                    É necessário inserir o nome do link externo
                                </small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url Link Externo</label>
                                <input type="text" class="form-control" v-model="carousel.url_link">

                                <small v-show="carousel.name_link.length && !carousel.url_link" style="color: red;">
                                    É necessário inserir a url do link externo
                                </small>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-6">
                                    <div class="text-start">
                                        <a :href="urlIndexCarousel" class="btn btn-secondary btn-sm">Voltar</a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col text-end">
                                        <button class="btn btn-primary btn-sm" type="submit">Cadastrar</button>
                                    </div>
                                </div>
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
        urlIndexCarousel: String,
    },
    data() {
        return {
            loading: false,
            carousel: {
                title: '',
                description: '',
                image: null,
                text: '',
                name_link: '',
                url_link: '',
            },
        };
    },
    methods: {
        loadImage(e) {
            this.carousel.image = e.target.files[0];
        },
        save() {
            let formData = new FormData();
            formData.append('title', this.carousel.title);
            formData.append('description', this.carousel.description);
            formData.append('name_link', this.carousel.name_link);
            formData.append('url_link', this.carousel.url_link);
            formData.append('image', this.carousel.image);

            this.loading = true;

            axios.post('/admin/site/carousel/store', formData, { headers: { 'Content-Type': 'multipart/form-data' }
            }).then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
                    this.clearForm();
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.carousel.title = '';
            this.carousel.description = '';
            this.carousel.name_link = '';
            this.carousel.url_link = '';
            this.carousel.image = '';
        }
    }
}
</script>
