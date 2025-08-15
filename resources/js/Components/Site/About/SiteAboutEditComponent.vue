<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Editar Sobre</h5>
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
                                <label>Imagem</label>
                                <img v-show="!newImage" :src="'/storage/' + about.image" class="form-control h-50 w-50 mb-3  mx-auto d-block"
                                    width="200">

                                <img v-show="newImage" class="form-control mb-3 " :src="urlImage" width="200">
                                <input type="file" class="form-control h-50 w-50 mb-3  mx-auto d-block" @change="loadImage">
                            </div>
                            <div class="mb-3">
                                <label>Título</label>
                                <input type="text" class="form-control" v-model="about.title">
                            </div>
                            <div class="mb-3">
                                <label>Descrição</label>
                                <input type="text" class="form-control" v-model="about.description">
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
        id: String,
        urlIndexAbout: String,
    },
    data() {
        return {
            loading: false,
            about: {

            },
            newImage: null,
            urlImage: null,
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {

            this.loading = true;
            axios.get('/admin/site/site-about/find/' + this.id)
                .then(response => {
                    this.about = response.data.about;
                }).catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        loadImage(e) {
            this.newImage = e.target.files[0];
            this.urlImage = URL.createObjectURL(this.newImage);
        },
        save() {
            let formData = new FormData();

            if (this.newImage) {
                formData.append('image', this.newImage);
            }

            if (this.about.title) {
                formData.append('title', this.about.title);
            }

            if (this.about.description) {
                formData.append('description', this.about.description);
            }

            axios.post('/admin/site/site-about/update/' + this.about.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
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
