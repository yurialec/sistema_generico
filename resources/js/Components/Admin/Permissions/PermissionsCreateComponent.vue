<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Permissões</h5>
            </div>
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save">
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input type="text" id="descricao" class="form-control" v-model="permission.label"
                                    required />
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" id="nome" class="form-control" v-model="permission.name" required />
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexPermission" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexPermission: String,
    },
    data() {
        return {
            permission: {
                name: '',
                label: '',
            },
            loading: null,
        };
    },
    mounted() {
    },
    methods: {
        save() {
            this.loading = false;
            axios.post('/admin/permissions/store', this.permission)
                .then(response => {
                    alertSuccess('Operação realizada com sucesso!');
                    this.clearForm();
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.permission.name = '';
            this.permission.label = '';
        }
    }
}
</script>