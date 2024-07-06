<template>
    <div id="formulario" class="row justify-content-center">
        <div class="col-sm-6">

            <h4>Meu Cadastro</h4>

            <alert-component tipo="success" :detalhes="msg" titulo="Alteração realizada com suecesso"
                v-if="alertStatus === true"></alert-component>
            <alert-component tipo="danger" titulo="Erro ao atualizar cadastro" :detalhes="msg"
                v-if="alertStatus === false">
            </alert-component>

            <form method="POST" action="" @submit.prevent="salvar()">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" v-model="user.name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" v-model="user.email" @change="functionValidateEmail">
                    <div style="margin-top: 10px;" v-if="validEmail == false" class="alert alert-danger" role="alert">
                        E-mail inválido.
                    </div>
                </div>
                <div class="form-group">
                    <label>Perfil</label>
                    <select class="form-control" v-model="user.role_id">
                        <option value="1">Admin</option>
                        <option value="2">Gestor</option>
                        <option value="3">Técnico</option>
                        <option value="4">Operador</option>
                        <option value="5">user</option>
                    </select>
                </div>

                <div class="form-group" v-show="changePassword">
                    <hr>
                    <label>Senha</label>
                    <input type="text" class="form-control" v-model="user.password">
                    <label>Confirmar senha</label>
                    <input type="text" class="form-control" v-model="confirmPassword">
                </div>

                <div class="container" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col text-start">
                            <a href="#" class="btn btn-primary btn-sm" @click="changePass()">Alterar senha</a>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-primary btn-sm" @click="salvar()">Atualizar</a>
                        </div>
                    </div>
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
            user: {
                name: '',
                email: '',
                role_id: '',
                password: '',
            },
            changePassword: false,
            validEmail: null,
            alertStatus: null,
            msg: [],
        };
    },
    computed: {

    },
    mounted() {
        this.getProfile();
    },
    methods: {
        functionValidateEmail() {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.user.email)) {
                this.validEmail = true;
            } else {
                this.validEmail = false;
            }
        },
        validatePassword() {
            
        },
        getProfile() {
            axios.get('admin/users/profile-view')
                .then(response => {
                    this.user = response.data.profile;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        salvar() {
            let config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }

            axios.post('/admin/users/update/' + this.user.id, this.user, config)
                .then(response => {
                    this.alertStatus = true;
                    console.log(response);
                    this.msg = response;
                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.msg = errors.response;
                });
        },
        changePass() {
            if (!this.changePassword) {
                this.changePassword = true;
            } else {
                this.changePassword = false;
            }
        }
    },
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