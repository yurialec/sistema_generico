<template>
    <div id="formulario" class="row justify-content-center">
        <div class="col-sm-6">

            <div v-if="alertStatus === true" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-check"></i> Registro alterado com sucesso
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div v-if="alertStatus === false" class="alert alert-danger" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i> Erro ao alterar registro
            </div>

            <form method="POST" action="" @submit.prevent="salvar()">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" v-model="role.name">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-start" style="margin-top: 10px;">
                                <a :href="this.urlIndexRole" class="btn btn-secondary btn-sm">Voltar</a>
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
        },
        urlIndexRole: String,
    },
    data() {
        return {
            role: JSON.parse(this.roleById),
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

            axios.post('/admin/roles/update/' + this.role.id, this.role, config)
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