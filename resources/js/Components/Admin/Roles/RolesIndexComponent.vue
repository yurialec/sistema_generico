<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center my-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else class="card">
            <div class="card-header py-2">
                <div class="row align-items-center g-2">
                    <div class="col-md-3 col-12">
                        <h5 class="mb-0">Perfis</h5>
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
                        <a :href="urlCreateRole" class="btn btn-sm btn-success">
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
                                <th>Nome</th>
                                <th>Permissões</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in this.roles.data" :key="role.id">
                                <th>{{ role.id }}</th>
                                <td>{{ role.name }}</td>
                                <td>
                                    <span v-for="permission in role['permissions']" class="badge bg-success"
                                        id="span-role-permissions">{{ permission.label }}</span>&nbsp;
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger me-1"
                                        @click="confirmExclusion(role.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <a :href="urlEditRole.replace('_id', role.id)"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-2">
                <nav v-if="roles.links.length > 0">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <li v-for="(link, key) in roles.links" :key="key"
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

export default {
    props: {
        urlCreateRole: String,
        urlEditRole: String,
    },
    data() {
        return {
            loading: false,
            roles: {
                data: [],
                links: []
            },
            searchFilter: '',
        };
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        getRoles(url = '/admin/roles/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.roles = response.data.roles;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        search() {
            this.getRoles(`/admin/roles/list?search=${this.searchFilter}`);
        },
        pagination(url) {
            if (url) {
                this.getRoles(url);
            }
        },
        confirmExclusion(id) {
            this.confirmYesNo('Deseja excluir o perfil?').then(() => {
                axios.delete('/admin/roles/delete/' + id)
                    .then(response => {
                        this.getRoles();
                        this.alertSuccess('Funcionou!');
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