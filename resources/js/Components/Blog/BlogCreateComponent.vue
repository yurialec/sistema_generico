<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Blog</h5>
            </div>
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" v-model="blog.title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control mb-3" v-model="blog.description"></textarea>
                            </div>
                            <hr>

                            <div class="form-group">
                                <input class="form-control mb-3 mt-3" type="file" multiple @change="onFileChange" />
                                <div class="jumbotron">
                                    <div class="row">
                                        <div class="div-blog-image col-md-4" v-for="(image, index) in images"
                                            :key="index">
                                            <button class="btn btn-danger btn-sm mb-2" type="button"
                                                @click="removeImage(index)"
                                                style="position: absolute;  top: 5px;  right: 5px;  z-index: 10;">
                                                &times;
                                            </button>
                                            <img :src="image.preview" class="preview img-thumbnail"
                                                style="width: 100%;  border-radius: 10px;  object-fit: cover;" />
                                            <div style="text-align: center;  padding: 10px 0; font-weight: bold;">
                                                {{ image.name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexBlog" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexBlog: String,
    },
    data() {
        return {
            loading: false,
            blog: {
                title: '',
                description: '',
            },
            images: [],
        };
    },
    methods: {
        onFileChange(e) {
            const selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
                let reader = new FileReader();
                let file = selectedFiles[i];
                reader.onload = (event) => {
                    this.images.push({
                        file: file,
                        name: file.name,
                        preview: event.target.result
                    });
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(index) {
            this.images.splice(index, 1);
        },
        save() {
            const formData = new FormData();
            formData.append('title', this.blog.title);
            formData.append('description', this.blog.description);

            this.images.forEach((image, index) => {
                formData.append(`images[${index}]`, image.file);
            });

            axios.post('/admin/blog/store', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(response => {
                this.alertSuccess('Operação realizada com sucesso!');
                window.scrollTo(0, 0);
                this.clearForm();
            }).catch(errors => {
                this.alertDanger(errors);
                window.scrollTo(0, 0);
            }).finally(() => {
                this.loading = false;
            });
        },
        clearForm() {
            this.blog.title = '';
            this.blog.description = '';
            this.images = [];
        }
    }
}
</script>
