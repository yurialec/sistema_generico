<template>
    <div v-if="loading" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <div v-else class="card shadow-sm border-0">
        <div class="card-header py-3 bg-light">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h5 class="mb-0">Carousel</h5>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <a :href="urlCreateCarousel" type="button" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th class="col-md-1">Preview</th>
                            <th class="col-md-2">Título</th>
                            <th class="col-md-2">Descrição</th>
                            <th class="col-md-2">Nome Link Externo</th>
                            <th class="col-md-2">Url Link Externo</th>
                            <th class="col-md-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="carousel in carousels.data" :key="carousel.id">
                            <td class="col-md-1"><img :src="'/storage/' + carousel.image" width="80"></td>
                            <td class="col-md-2">{{ carousel.title }}</td>
                            <td class="col-md-2"
                                style="max-width:100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
                                {{ carousel.description }}
                            </td>
                            <td class="col-md-2">{{ carousel.name_link }}</td>
                            <td class="col-md-2">{{ carousel.url_link }}</td>
                            <td class="col-md-1">
                                <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal"
                                    data-bs-target="#viewImgModal" @click="viewImage(carousel)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a type="button" class="btn btn-sm btn-outline-warning me-2"
                                    :href="urlEditCarousel.replace('_id', carousel.id)">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" @click="deleteRecord(carousel.id)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="viewImgModal" tabindex="-1" aria-labelledby="viewImgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImgModalLabel">Visualizar imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <img :src="'/storage/' + selectedCarousel.image" width="450">
                        <small>Nome: {{ selectedCarousel.name_link }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</template>

<script>
import axios from 'axios';

export default {
    props: {
        urlCreateCarousel: String,
        urlEditCarousel: String,
    },
    data() {
        return {
            loading: false,
            carousels: [],
            selectedCarousel: {},
        };
    },
    mounted() {
        this.getCarousel();
    },
    methods: {
        getCarousel() {
            this.loading = true;
            axios.get('admin/site/carousel/list')
                .then(response => {
                    this.carousels = response.data.carousels;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        deleteRecord(id) {
            this.confirmYesNo('Deseja excluir o conteúdo?').then(() => {
                axios.delete('/admin/site/carousel/delete/' + id)
                    .then(response => {
                        this.getCarousel();
                        this.alertSuccess('Registro excluido com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
        viewImage(carousel) {
            this.selectedCarousel = carousel;
        },
    }
}
</script>
