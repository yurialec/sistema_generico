<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden"></span>
            </div>
        </div>
        <div v-else class="card">
            <div class="card-header py-2">
                <div class="row align-items-center g-2">
                    <div class="col-md-3 col-12">
                        <h5 class="mb-0">Permissões</h5>
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
                        <a :href="urlCreatePermission" class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Cadastrar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Label</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(permission, index) in permissions.data" :key="permission.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ permission.label }}</td>
                                <td>{{ permission.name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger me-1"
                                        @click="confirmExclusion(permission.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <a :href="urlEditPermission.replace('_id', permission.id)"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="permissions.data.length === 0">
                                <td colspan="4" class="text-center">Nenhum registro encontrado.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-2">
                <nav v-if="permissions.links.length > 0">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <li v-for="(link, i) in permissions.links" :key="i"
                            :class="['page-item', { active: link.active, disabled: !link.url }]">
                            <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreatePermission: String,
        urlEditPermission: String,
    },
    data() {
        return {
            loading: false,
            permissions: {
                data: [],
                links: []
            },
            searchFilter: '',
            permissionToDelete: null,
        };
    },
    mounted() {
        this.getPermissions();
    },
    methods: {
        getPermissions(url = '/admin/permissions/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.permissions = response.data.permission;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        search() {
            this.getPermissions(`/admin/permissions/list?search=${this.searchFilter}`);
        },
        pagination(url) {
            if (url) {
                this.getPermissions(url);
            }
        },
        confirmExclusion(id) {
            this.confirmYesNo('Deseja excluir a permissão?').then(() => {
                axios.delete('/admin/permissions/delete/' + id)
                    .then(response => {
                        this.permissionToDelete = null;
                        this.getPermissions();
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
    }
}
</script>