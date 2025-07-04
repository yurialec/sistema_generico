<template>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Meu Cadastro</h4>
                    </div>
                    <div class="card-body">
                        <div v-if="loading" class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>

                        <form v-else @submit.prevent="save()" autocomplete="off">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" id="name" class="form-control" v-model="userProfile.name"
                                    autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" v-model="userProfile.email"
                                    @input="validateEmail" autocomplete="off">
                                <div class="mt-2" v-if="validEmail === false">
                                    <div class="alert alert-danger p-2" role="alert">E-mail inválido.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Perfil</label>
                                <input type="text" class="form-control" v-model="userProfile.role" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permissões</label>
                                <div>
                                    <p v-if="userProfile.permissions.length === 0"><strong>Você não tem nenhuma
                                            permissão</strong></p>
                                    <span v-for="permission in userProfile.permissions" :key="permission.id"
                                        class="badge bg-success me-1">
                                        {{ permission.label }}
                                    </span>
                                </div>
                            </div>

                            <div v-if="changePassword">
                                <hr class="my-4">
                                <div class="row mb-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label">Senha</label>
                                        <input :type="inputPass ? 'text' : 'password'" class="form-control"
                                            v-model="userProfile.password" @input="passwordCheck"
                                            autocomplete="new-password">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label">Confirmar Senha</label>
                                        <div class="input-group">
                                            <input :type="inputPass ? 'text' : 'password'" class="form-control"
                                                v-model="confirmPassword" autocomplete="new-password">
                                            <button class="btn btn-outline-secondary" type="button"
                                                @click="showPassword()">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>Requisitos mínimos para a senha:</h6>
                                    <small :class="has_six_chars ? 'text-success' : 'text-danger'">No mínimo 6
                                        caracteres.</small><br>
                                    <small :class="has_lowercase ? 'text-success' : 'text-danger'">Conter pelo menos uma
                                        letra.</small><br>
                                    <small :class="has_number ? 'text-success' : 'text-danger'">Conter pelo menos um
                                        número.</small><br>
                                    <small :class="has_special ? 'text-success' : 'text-danger'">Conter pelo menos um
                                        caractere especial.</small><br>
                                    <small class="text-danger" v-if="userProfile.password !== confirmPassword">A
                                        confirmação de senha precisa ser igual à senha.</small>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4">
                                <button class="btn btn-outline-primary w-100 w-sm-auto" type="button"
                                    @click="changePass()">Alterar senha</button>
                                <button class="btn btn-primary w-100 w-sm-auto" type="submit">Atualizar</button>
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
    data() {
        return {
            loading: false,
            user: {},
            userProfile: {
                name: '',
                email: '',
                role: '',
                permissions: [],
                password: '',
            },
            confirmPassword: '',
            inputPass: false,
            has_number: '',
            has_lowercase: '',
            has_special: '',
            has_six_chars: '',
            changePassword: false,
            validEmail: null,
        };
    },
    mounted() {
        this.getProfile();
    },
    methods: {
        validateEmail() {
            const emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            this.validEmail = emailPattern.test(this.userProfile.email);
        },
        getProfile() {
            this.loading = true;
            axios.get('admin/profile')
                .then(response => {
                    this.user = response.data.profile;
                    this.userProfile.name = this.user.name;
                    this.userProfile.email = this.user.email;
                    this.userProfile.role = this.user.role.name;
                    this.userProfile.permissions = this.user.role.permissions;
                })
                .catch(error => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        save() {
            const payload = {
                name: this.userProfile.name,
                email: this.userProfile.email,
                role_id: this.user.role_id
            };

            if (this.userProfile.password) {
                payload.password = this.userProfile.password;
            }

            this.loading = true;
            axios.post('/admin/users/update/' + this.user.id, payload)
                .then(response => {
                    this.alertSuccess('Dados alterados com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        changePass() {
            this.changePassword = !this.changePassword;
            if (!this.changePassword) {
                this.userProfile.password = '';
                this.confirmPassword = '';
            }
        },
        passwordCheck() {
            if (this.userProfile.password) {
                this.has_number = /\d/.test(this.userProfile.password);
                this.has_lowercase = /[a-zA-Z]/.test(this.userProfile.password);
                this.has_special = /[!@#\$%\^\&*\)\(+=._-]/.test(this.userProfile.password);
                this.has_six_chars = this.userProfile.password.length >= 6;
            }
        },
        showPassword() {
            this.inputPass = !this.inputPass;
        },
    },
}
</script>
