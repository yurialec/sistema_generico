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
                    <h5 class="mb-0">Texto principal</h5>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <a v-if="!main?.id" :href="urlCreateMainText" type="button" class="btn btn-sm btn-success"><i
                            class="bi bi-plus-circle me-1"></i> Cadastrar</a>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Texto</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="main">
                                <td>{{ main.title }}</td>
                                <td class="text-ellipsis">{{ main.text }}</td>
                                <td>
                                    <a :href="urlEditMain.replace('_id', main.id)"
                                        class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" @click="deleteRegister(main.id)"
                                        title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="3" class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        urlCreateMainText: String,
        urlEditMain: String,
    },
    data() {
        return {
            loading: false,
            main: {
                title: '',
                text: '',
            },
        };
    },
    mounted() {
        this.getMainText();
    },
    methods: {
        getMainText() {
            this.loading = true;
            axios.get('/admin/site/main-text/get-main-text')
                .then(response => {
                    this.main = response.data.mainText;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        deleteRegister(id) {
            this.confirmYesNo('Deseja excluir o conteúdo?').then(() => {
                axios.delete('/admin/site/main-text/delete/' + id)
                    .then(response => {
                        this.getMainText();
                        this.alertSuccess('Operação realizada com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
    }
}
</script>
<style>
.text-ellipsis {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
