<template>
    <div id="formulario" class="row justify-content-center">
        <div class="col-sm-6">

            <alert-component tipo="success" :detalhes="msg" titulo="Alteração realizada com sucesso"
                v-if="alertStatus === true"></alert-component>
            <alert-component tipo="danger" titulo="Erro ao cadastrar Perfil" :detalhes="msg"
                v-if="alertStatus === false">
            </alert-component>

            <form method="POST" action="" @submit.prevent="salvar()">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" v-model="role.name">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-start" style="margin-top: 10px;">
                                <a href="#" class="btn btn-secondary btn-sm" @click.prevent="voltar">Voltar</a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-end" style="margin-top: 10px;">
                                <a href="#" class="btn btn-primary btn-sm" @click="salvar()">Salvar Alterações</a>
                            </div>
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
    props: {
        roleById: {
            type: Object,
        }
    },
    data() {
        return {
            role: JSON.parse(this.roleById),
            alertStatus: null,
            msg: [],
        };
    },
    methods: {
        voltar() {
            window.history.back();
        },
        salvar() {
            let config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }

            axios.post('/admin/perfis/update/' + this.role.id, this.role, config)
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