<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="mb-0">Editar Menu</h5>
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
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="menu.label" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ícone</label>
                                <input type="text" class="form-control" v-model="menu.icon" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Url</label>
                                <input type="text" class="form-control" v-model="menu.url" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                                <span class="fw-semibold">Submenus</span>
                                <button type="button" @click="addRow" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-plus-square"></i> Adicionar
                                </button>
                            </div>
                            <div v-for="(child, index) in menu.children" :key="index" class="row align-items-end mb-3">
                                <div class="col-lg-4">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" v-model="child.label" placeholder="Nome">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Ícone</label>
                                    <input type="text" class="form-control" v-model="child.icon" placeholder="Ícone">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">URL</label>
                                    <input type="text" class="form-control" v-model="child.url" placeholder="URL">
                                </div>
                                <div class="col-lg-1 d-flex align-items-end justify-content-center">
                                    <button type="button" @click="deleteRow(index)"
                                        class="btn btn-outline-danger rounded-circle">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-5">
                                <a :href="urlIndexMenu" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
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
import Multiselect from 'vue-multiselect';

export default {
    components: { Multiselect },
    props: {
        id: String,
        urlIndexMenu: String,
    },
    data() {
        return {
            loading: false,
            menu: {},
        };
    },
    mounted() {
        this.getMenu();
    },
    methods: {
        getMenu() {
            this.loading = true;
            axios.get('admin/menu/find/' + this.id)
                .then(response => {
                    this.menu = response.data.menu;
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        save() {
            axios.post('/admin/menu/update/' + this.id, this.menu)
                .then(response => {
                    window.scrollTo(0, 0);
                    alertSuccess('Alterado com sucesso!');
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        addRow() {
            this.menu.children.push({
                label: "",
                icon: "",
                url: "",
                active: 1,
                son: this.menu.id
            });
        },
        deleteRow(index) {
            this.menu.children.splice(index, 1);
        }
    }
}
</script>
