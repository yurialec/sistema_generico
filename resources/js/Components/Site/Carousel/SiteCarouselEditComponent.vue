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
                                <input type="file" required class="form-control" @change="onFileChange">
                                <div v-if="urlImage" class="mt-3 text-center">
                                    <p class="mb-1">Preview da nova imagem</p>
                                    <img :src="urlImage" alt="Preview" class="img-fluid rounded shadow-sm"
                                        style="max-height: 200px;">
                                </div>
                                <div v-else-if="carousel.image" class="mt-3 text-center">
                                    <p class="mb-1">Imagem atual</p>
                                    <img :src="carousel.image" alt="Imagem atual" class="img-fluid rounded shadow-sm"
                                        style="max-height: 200px;">
                                </div>
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
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url Link Externo</label>
                                <input type="text" class="form-control" v-model="carousel.url_link">
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
        id: String,
        urlIndexCarousel: String,
    },
    data() {
        return {
            loading: false,
            carousel: {},
            newImage: null,
            file: '',
            urlImage: null,
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            axios.get(`/admin/site/carousel/find/${this.id}`)
                .then(response => {
                    this.carousel = response.data.carousel;
                }).catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        save() {
            let formData = new FormData();

            if (this.newImage) {
                formData.append('image', this.newImage);
            }

            if (this.carousel.title) {
                formData.append('title', this.carousel.title);
            }

            if (this.carousel.description) {
                formData.append('description', this.carousel.description);
            }

            if (this.carousel.url_link) {
                formData.append('url_link', this.carousel.url_link);
            }

            if (this.carousel.name_link) {
                formData.append('name_link', this.carousel.name_link);
            }

            axios.post('/admin/site/carousel/update/' + this.carousel.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.alertSuccess('Registro alterado com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
    }
}
</script>
