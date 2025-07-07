<template>
    <div v-if="loading" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>
    <div v-else class="card shadow-sm border-0">
        <div class="card-header py-3 bg-light">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h5 class="mb-0">Logotipo</h5>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <a v-if="!logo?.id" :href="urlCreateLogo" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Preview</th>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="logo?.id">
                            <td>
                                <img :src="'/storage/' + logo.image" alt="Logo preview" class="img-thumbnail"
                                    style="width: 80px;">
                            </td>
                            <td>{{ logo.name }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" title="Visualizar"
                                    @click="openImage">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a :href="urlEditLogo.replace('_id', logo.id)"
                                    class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" @click="deleteRegister(logo.id)"
                                    title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="text-center text-muted py-3">Nenhum registro encontrado.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImageLabel">Visualizar Imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-center">
                    <img :src="'/storage/' + logo.image" alt="Visualização do logo" class="img-fluid rounded shadow">
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
        urlCreateLogo: String,
        urlEditLogo: String,
    },
    data() {
        return {
            loading: false,
            logo: {},
        };
    },
    mounted() {
        this.getLogo();
    },
    methods: {
        getLogo() {
            this.loading = true;
            axios.get('admin/site/logo/get-logo')
                .then(response => {
                    this.logo = response.data.logo || {};
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        deleteRegister(id) {
            this.confirmYesNo('Deseja excluir a logo?').then(() => {
                this.loading = true;
                axios.delete(`/admin/site/logo/delete/${id}`)
                    .then(() => {
                        this.getLogo();
                        this.alertSuccess('Excluído com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        openImage() {
            const modal = new Modal(document.getElementById('modalImage'));
            modal.show();
        }
    }
}
</script>
