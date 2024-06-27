<template>
    <div id="formulario" class="row justify-content-center">
        <div class="col-sm-6">

            <alert-component tipo="success" :detalhes="msg" titulo="Cadastro realizado com sucesso"
                v-if="alertStatus === true"></alert-component>
            <alert-component tipo="danger" titulo="Erro ao cadastrar usuário" :detalhes="msg"
                v-if="alertStatus === false">
            </alert-component>

            <form method="POST" action="" @submit.prevent="salvar()">
                <input type="hidden" name="_token" :value="csrf_token">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" v-model="usuario.name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" v-model="usuario.email" @change="functionValidateEmail">

                    <div style="margin-top: 10px;" v-if="validEmail == false" class="alert alert-danger" role="alert">
                        E-mail inválido.
                    </div>

                </div>
                <div class="form-group">
                    <label>Perfil</label>
                    <select class="form-control" v-model="usuario.role_id">
                        <option value="1">Admin</option>
                        <option value="2">Gestor</option>
                        <option value="3">Técnico</option>
                        <option value="4">Operador</option>
                        <option value="5">usuario</option>
                    </select>
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
    props: [
        'csrf_token',
    ],
    data() {
        return {
            usuario: {
                name: '',
                email: '',
                role_id: '',
            },
            validEmail: null,
            alertStatus: null,
            msg: [],
        };
    },
    methods: {
        isEmailValid() {

        },
        functionValidateEmail() {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.usuario.email)) {
                this.validEmail = true;
            } else {
                this.validEmail = false;
            }
        },
        salvar() {
            let config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }

            axios.post('http://localhost:8000/admin/usuarios/cadastrar', this.usuario, config)
                .then(response => {
                    this.alertStatus = true;
                    console.log(response);
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