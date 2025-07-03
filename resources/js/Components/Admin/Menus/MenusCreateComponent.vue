<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="mb-0">Cadastrar Menu</h5>
                        </div>
                        <div class="col-sm text-end">
                            <a href="https://icons.getbootstrap.com/" target="_blank">Biblioteca de
                                ícones</a>&nbsp;&nbsp;
                            <i class="bi bi-info-circle fs-4" style="color: #00a803;" data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Ao adicionar o nome do ícone, você deve inserir sem as tags HTML"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" class="form-control" v-model="menu.label" required>
                            </div>
                            <div class="mb-3">
                                <label>Ícone</label>
                                <input type="text" class="form-control" v-model="menu.icon" required>
                            </div>
                            <div class="mb-3">
                                <label>Url</label>
                                <input type="text" class="form-control" v-model="menu.url">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexMenu" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexMenu: String,
    },
    data() {
        return {
            loading: false,
            menu: {
                label: '',
                icon: '',
                url: '',
            },
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios.post('/admin/menu/store', this.menu)
                .then(response => {
                    alertSuccess('Cadastrado com sucesso!');
                    this.clearForm();
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.menu.label = '';
            this.menu.icon = '';
            this.menu.url = '';
        }
    }
}
</script>