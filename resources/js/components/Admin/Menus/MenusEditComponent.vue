<template>
    <div class="card">
        <div class="card-header">
            <h4>Editar Menu</h4>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-sm-6">

                    <div v-if="alertStatus === true" class="alert alert-success alert-dismissible fade show"
                        role="alert">
                        <i class="fa-regular fa-circle-check"></i> Registro atualizado com sucesso
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div v-if="alertStatus === false" class="alert alert-danger alert-dismissible fade show"
                        role="alert">
                        <i class="fa-regular fa-circle-xmark"></i> Erro ao atualizar registro
                        <hr>
                        <ul v-for="msg in messages.data.errors">
                            <li>{{ msg[0] }}</li>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="" @submit.prevent="save()" class="col-lg-8" autocomplete="off">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" v-model="menu.menu[0].label">
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-6">
                                <div class="text-start">
                                    <a :href="urlIndexMenu" class="btn btn-secondary btn-sm">Voltar</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col text-end">
                                    <button class="btn btn-primary btn-sm" type="submit">Atualizar</button>
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
import Multiselect from 'vue-multiselect';

export default {
    components: { Multiselect },
    props: {
        menuById: {
            type: Object,
            required: true
        },
        urlIndexMenu: String,
    },
    data() {
        return {
            menu: {
                menu: JSON.parse(this.menuById),
            },
            alertStatus: null,
        };
    },
    methods: {
        save() {
            axios.post('/admin/menu/update/' + this.menu.menu[0].id, this.menu.menu[0])
                .then(response => {
                    this.alertStatus = true;
                    this.messages = response.data;
                })
                .catch(errors => {
                    this.alertStatus = false;
                    this.messages = errors.response;
                });
        },
    }
}
</script>
