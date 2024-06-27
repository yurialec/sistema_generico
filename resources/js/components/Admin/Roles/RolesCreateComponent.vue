<template>
    <div id="formulario" class="row justify-content-center">
        <div class="col-sm-6">

            <alert-component tipo="success" :detalhes="msg" titulo="Cadastro realizado com sucesso"
                v-if="alertStatus === true"></alert-component>
            <alert-component tipo="danger" titulo="Erro ao cadastrar Perfil" :detalhes="msg"
                v-if="alertStatus === false">
            </alert-component>

            <form method="POST" action="" @submit.prevent="salvar()">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" v-model="role.name">
                </div>
                <div class="text-end" style="margin-top: 10px;">
                    <a href="#" class="btn btn-primary btn-sm" @click="salvar()">Cadastrar</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            role: {
                name: '',
            },
            alertStatus: null,
            msg: [],
        };
    },
    methods: {
        salvar() {
            let config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }

            axios.post('/admin/roles/store', this.role, config)
                .then(response => {
                    this.alertStatus = true;
                    this.msg = response;

                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.msg = errors.response;
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