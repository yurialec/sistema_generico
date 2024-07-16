<template>
    <div class="card">
        <div class="card-header">
            <h4>Cadastrar permissão</h4>
        </div>
        <div class="card-body">
            <div id="formulario" class="row justify-content-center">
                <div class="col-sm-6">

                    <div v-if="this.alertStatus === true" class="alert alert-success alert-dismissible fade show"
                        role="alert">
                        <i class="fa-regular fa-circle-check"></i> Registro cadastrado com sucesso
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div v-if="this.alertStatus === false" class="alert alert-danger alert-dismissible fade show"
                        role="alert">
                        <i class="fa-regular fa-circle-xmark"></i> Erro ao cadastrar registro
                        <hr>
                        <ul v-for="msg in this.messages.data.errors">
                            <li>{{ msg[0] }}</li>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="" @submit.prevent="salvar()">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" v-model="permission.name">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-start" style="margin-top: 10px;">
                                    <a :href="this.urlIndexPermission" class="btn btn-secondary btn-sm">Voltar</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-end" style="margin-top: 10px;">
                                    <a href="#" class="btn btn-primary btn-sm" @click="salvar()">Cadastrar</a>
                                </div>
                            </div>
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
        urlIndexPermission: String,
    },
    data() {
        return {
            permission: {
                name: '',
            },
            alertStatus: null,
            msg: [],
        };
    },
    methods: {
        salvar() {
            axios.post('/admin/permissions/store', this.permission)
                .then(response => {
                    this.alertStatus = true;
                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.messages = errors.response;
                });
        }
    }
}
</script>
<style>
#formulario {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
}
</style>