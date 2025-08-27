<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Editar Carousel</h5>
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
            carousel: {
                id: null,
                image: null,
            },
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get(`/admin/site/carousel/find/${this.id}`)
                .then(({ data }) => {
                    this.carousel = { ...this.carousel, ...(data.carousel ?? {}) };
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        loadImage(e) {
            const file = e.target.files?.[0] ?? null;
            this.carousel.image = file;
        },
        async save() {
            if (!this.carousel?.id) {
                this.alertDanger('Registro não encontrado. Recarregue a página.');
                return;
            }

            if (!this.carousel?.image) {
                this.alertDanger('Selecione uma imagem antes de cadastrar.');
                return;
            }

            const formData = new FormData();
            formData.append('image', this.carousel.image);
            formData.append('_method', 'PUT');

            this.loading = true;
            try {
                await axios.post(`/admin/site/carousel/update/${this.carousel.id}`, formData, {
                });
                this.alertSuccess('Registro alterado com sucesso!');
            } catch (err) {
                this.alertDanger(err);
            } finally {
                this.loading = false;
            }
        },
    }
}
</script>
