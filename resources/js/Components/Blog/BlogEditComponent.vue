<template>
    <div class="card">
        <div class="card-header">
            <h4>Editar Blog</h4>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div v-if="loading" class="d-flex justify-content-center my-4">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <form v-else @submit.prevent="save" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control" v-model="blog.title" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <input type="text" class="form-control" v-model="blog.description" />
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Imagens</label>
                            <input type="file" class="form-control my-2" multiple @change="onFileChange" />

                            <div class="row g-3">
                                <div v-for="image in blog.images" :key="'old-' + image.id"
                                    class="col-md-4 position-relative">
                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        @click="removeImage(image.id)">
                                        &times;
                                    </button>
                                    <img :src="'/storage/' + image.image_path" class="img-thumbnail w-100"
                                        style="border-radius: 10px; object-fit: cover;" />
                                </div>

                                <div v-for="(newImage, index) in newImages" :key="'new-' + index"
                                    class="col-md-4 position-relative">
                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                        @click="removeNewImages(index)">
                                        &times;
                                    </button>
                                    <img :src="newImage.preview" class="img-thumbnail w-100"
                                        style="border-radius: 10px; object-fit: cover;" />
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a :href="urlIndexBlog" class="btn btn-secondary btn-sm">Voltar</a>
                            <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
                        </div>
                    </form>
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
        urlIndexBlog: String,
    },
    data() {
        return {
            loading: false,
            blog: { images: [] },
            newImages: [],
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/blog/find/' + this.id)
                .then(response => {
                    this.blog = response.data.blog;
                })
                .catch(this.alertDanger)
                .finally(() => {
                    this.loading = false;
                });
        },
        onFileChange(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.newImages.push({
                        file,
                        preview: event.target.result,
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        removeImage(id) {
            this.blog.images = this.blog.images.filter(image => image.id !== id);
        },
        removeNewImages(index) {
            this.newImages.splice(index, 1);
        },
        save() {
            const formData = new FormData();
            formData.append('title', this.blog.title);
            formData.append('description', this.blog.description);

            this.newImages.forEach((image, i) => {
                formData.append(`new_images[${i}]`, image.file);
            });

            this.blog.images.forEach((image, i) => {
                formData.append(`old_data[${i}]`, image.image_path);
            });

            this.loading = true;
            axios.post(`/admin/blog/update/${this.blog.id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
                .then(() => this.alertSuccess('Operação realizada com sucesso!'))
                .catch(this.alertDanger)
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>
