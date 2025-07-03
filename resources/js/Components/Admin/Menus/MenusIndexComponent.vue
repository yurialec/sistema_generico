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
                                <button class="btn btn-sm btn-outline-danger me-1" @click="confirmExclusion(menu.id)">
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
        confirmExclusion(id) {
            this.confirmYesNo('Deseja excluir o menu?').then(() => {
                axios.delete('/admin/menu/delete/' + id)
                    .then(response => {
                        this.getMenus();
                        this.alertSuccess('Excluido com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
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