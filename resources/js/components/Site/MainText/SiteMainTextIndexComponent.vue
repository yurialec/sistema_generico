<template>
    <div v-if="this.alertStatus === true" class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-regular fa-circle-check"></i> Registro exluido com sucesso
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div v-if="this.alertStatus == 'notAllowed'" class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i> Você não tem permissão para acessar essa funcionalidade
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 text-start">
                    <h3>Texto principal</h3>
                </div>

                <div class="col-md-6 text-end">
                    <a :href="urlCreateMainText" type="button" class="btn btn-primary btn-sm">Cadastrar</a>
                </div>
            </div>
        </div>

        <div v-if="loading === true" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else class="card-body">
            <div v-if="this.main.length == 0" class="text-center">
                <p>Nenhum resultado encontrado</p>
            </div>

            <div v-else class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Texto</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                            <td>{{ main.title }}</td>
                            </th>
                            <td>{{ main.text }}</td>
                            <td>
                                <a :href="'/admin/site/main-text/edit/' + main.id">
                                    <i class="fa-regular fa-pen-to-square fa-lg"></i>
                                </a>
                                &nbsp;&nbsp;&nbsp;

                                <button type="button" style="color: red; padding: 0;" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" @click="confirmExclusion(main.id)">
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar este registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" @click="deleteRecord">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreateMainText: String,
    },
    data() {
        return {
            mainToDelete: null,
            alertStatus: null,
            msg: [],
            loading: null,
            main: [],
        };
    },
    mounted() {
        this.getMainText();
    },
    methods: {
        getMainText() {
            this.loading = true;
            axios.get('admin/site/main-text/list')
                .then(response => {
                    this.main = response.data.mainText;
                })
                .catch(errors => {
                    this.alertStatus = 'error';
                }).finally(() => {
                });
            this.loading = false;
        },
        confirmExclusion(mainId) {
            this.mainToDelete = mainId;
        },
        deleteRecord() {
            if (this.mainToDelete !== null) {
                axios.delete('/admin/site/main-text/delete/' + this.mainToDelete)
                    .then(response => {
                        this.getMainText();
                        this.mainToDelete = null;

                        const modal = Modal.getInstance(document.getElementById('exampleModal'));
                        if (modal) {
                            modal.hide();
                        }

                        if (response.data == '') {
                            this.alertStatus = 'notAllowed';
                        } else {
                            this.alertStatus = true;
                        }

                    })
                    .catch(errors => {
                        const modal = Modal.getInstance(document.getElementById('exampleModal'));
                        if (modal) {
                            modal.hide();
                        }

                        if (errors.response.status == 405) {
                            this.alertStatus = 'notAllowed';
                        }
                    });
            }
        },
    }
}
</script>