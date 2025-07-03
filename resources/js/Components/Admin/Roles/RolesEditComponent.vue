<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Editar perfil</h5>
            </div>
            <div v-if="loading" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="role.name" required>
                            </div>
                            <div class="mb-3">
                                <multiselect v-model="role.permissionsSelected" :options="permissions" :multiple="true"
                                    label="label" track-by="id">
                                </multiselect>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexRole" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
import Multiselect from 'vue-multiselect';

export default {
    components: { Multiselect },
    props: {
        id: String,
        urlIndexRole: String,
    },
    data() {
        return {
            loading: false,
            role: {
                name: '',
                permissionsSelected: [],
            },
            permissions: [],
        };
    },
    mounted() {
        this.find();
        this.getPermissions();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/roles/find/' + this.id)
                .then(response => {
                    this.role = response.data.role;
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        getPermissions() {
            this.loading = true;
            axios.get('/admin/roles/list-permissions')
                .then(response => {
                    this.permissions = response.data.permissions;
                    this.setSelectedPermissions();
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        save() {
            const permissionsIds = this.role.permissionsSelected.map(permission => permission.id);

            const dataToSend = {
                role_id: this.role.id,
                name: this.role.name,
                permissions: permissionsIds
            };

            this.loading = true;
            axios.post('/admin/roles/update/' + this.id, dataToSend)
                .then(response => {
                    alertSuccess('Operação realizada com sucesso!');
                })
                .catch(errors => {
                    alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        setSelectedPermissions() {
            const selectedPermissions = this.role.permissions.map(permission => {
                return this.permissions.find(p => p.id === permission.id);
            });
            this.role.permissionsSelected = selectedPermissions;
        }
    }
}
</script>
