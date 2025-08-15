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
                    <h5 class="mb-0">Sobre</h5>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <a v-if="!about?.id" :href="urlCreateAbout" type="button" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="col">Preview Imagem</th>
                            <th class="col">Título</th>
                            <th class="col">Descrição</th>
                            <th class="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="about">
                        <tr>
                            <td class="col-md-3"><img :src="'/storage/' + about.image" width="80"></td>
                            <td class="col-md-3">{{ about.title }}</td>
                            <td class="col-md-3"
                                style="max-width:100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
                                {{ about.description }}
                            </td>
                            <td class="col-md-3">
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1"
                                    data-bs-toggle="modal" data-bs-target="#viewImgModal" @click="viewImage(about)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a :href="urlEditAbout.replace('_id', about.id)"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    @click="deleteRecord(about.id)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewImgModal" tabindex="-1" aria-labelledby="viewImgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImgModalLabel">Visualizar imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <img :src="'/storage/' + selectedAbout.image" width="450">
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
        urlCreateAbout: String,
        urlEditAbout: String,
    },
    data() {
        return {
            loading: false,
            about: {
                title: '',
                description: '',
                image: null,
            },
            selectedAbout: {},
        };
    },
    mounted() {
        this.getAbout();
    },
    methods: {
        getAbout() {
            this.loading = true;
            axios.get('admin/site/site-about/list')
                .then(response => {
                    this.about = response.data.abouts;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        deleteRecord(id) {
            this.confirmYesNo('Deseja excluir o conteúdo?').then(() => {
                axios.delete('/admin/site/site-about/delete/' + id)
                    .then(response => {
                        this.alertSuccess('Operação realizada com sucesso!');
                        this.getAbout();
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
        viewImage(about) {
            this.selectedAbout = about;
        },
    }
}
</script>
