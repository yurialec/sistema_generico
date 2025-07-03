<template>
    <div v-if="loading" class="d-flex justify-content-center my-4">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <div v-else class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">Menus</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary" @click="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreateMenu" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Ícone</th>
                            <th>Url</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="menu in menus.data" :key="menu.id">
                            <th scope="row">{{ menu.id }}</th>
                            <td>{{ menu.label }}</td>
                            <td><i :class="menu.icon"></i></td>
                            <td>{{ menu.url }}</td>
                            <td>{{ menu.order }}&nbsp;
                                <button v-if="menu.order != 1" @click="changeOrderMenu(menu.id)" class="btn btn-sm">
                                    <i class="bi bi-chevron-double-up"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalDelete" @click="confirmExclusion(menu.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <a :href="urlEditMenu.replace('_id', menu.id)" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                        <tr v-if="menus.data.length === 0">
                            <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
            <nav v-if="menus.links.length > 0">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in menus.links" :key="i"
                        :class="['page-item', { active: link.active, disabled: !link.url }]">
                        <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0">Deseja realmente excluir este registro?</p>
                    <button type="button" class="btn btn-sm btn-secondary m-1" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-danger" @click="deleteRegister">Excluir</button>
                </div>
                <div class="modal-footer justify-content-center">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreateMenu: String,
        urlEditMenu: String,
    },
    data() {
        return {
            loading: false,
            menus: {
                data: [],
                links: []
            },
            searchFilter: '',
            menuToDelete: null,
        };
    },
    mounted() {
        this.getMenus();
    },
    methods: {
        search() {
            this.getMenus('admin/menu/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getMenus(url);
            }
        },
        getMenus(url = 'admin/menu/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.menus = response.data.menus;
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        confirmExclusion(menuId) {
            this.menuToDelete = menuId;
        },
        deleteRegister() {
            if (this.menuToDelete !== null) {
                axios.delete('/admin/menu/delete/' + this.menuToDelete)
                    .then(response => {
                        this.getMenus();
                        this.menuToDelete = null;
                        const modal = Modal.getInstance(document.getElementById('modalDelete'));
                        modal?.hide();
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        alertSuccess('Excluido com sucesso!');
                    })
                    .catch(errors => {
                        const modal = Modal.getInstance(document.getElementById('modalDelete'));
                        modal?.hide();
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        alertDanger(errors);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
        changeOrderMenu(menuId) {
            axios.post('/admin/menu/change-order-menu/' + menuId)
                .then(response => {
                    this.getMenus();
                    alertSuccess('Alterado com sucesso!');
                })
                .catch(errors => {
                    alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>