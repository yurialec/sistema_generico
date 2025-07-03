<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Editar Usuário</h5>
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
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="user.name">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Perfil</label>
                                <select class="form-control" v-model="user.role_id">
                                    <option v-for="role in this.roles" :value="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" v-model="user.email" @input="validateEmail"
                                    required autocomplete="off">
                                <div v-if="validEmail === false" class="alert alert-danger mt-2 mb-0 p-2 py-1"
                                    role="alert">
                                    E-mail inválido.
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning" @click="changePass">Alterar senha</button>
                            <div v-if="changePassword" class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Senha</label>
                                    <input :type="showPass ? 'text' : 'password'" class="form-control"
                                        v-model="user.password" @input="passwordCheck" required autocomplete="off">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Confirmar senha</label>
                                    <div class="input-group">
                                        <input :type="showPass ? 'text' : 'password'" class="form-control"
                                            v-model="confirmPassword" required autocomplete="off">
                                        <button class="btn btn-outline-secondary" type="button" @click="togglePassword">
                                            <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" v-if="user.password">
                                <h6>Requisitos mínimos da senha:</h6>
                                <small :class="has_six_chars ? 'text-success' : 'text-danger'">- No mínimo 6
                                    caracteres.</small><br>
                                <small :class="has_lowercase ? 'text-success' : 'text-danger'">- Contém
                                    letras.</small><br>
                                <small :class="has_number ? 'text-success' : 'text-danger'">- Contém
                                    números.</small><br>
                                <small :class="has_special ? 'text-success' : 'text-danger'">- Contém caractere
                                    especial.</small><br>
                                <small v-if="user.password !== confirmPassword" class="text-danger">- A confirmação deve
                                    ser igual à senha.</small>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexUser" class="btn btn-outline-secondary btn-sm">Voltar</a>
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

export default {
    props: {
        id: String,
        urlIndexUser: String,
    },
    data() {
        return {
            loading: false,
            roles: [],
            user: {
                name: '',
                email: '',
                password: '',
                role_id: '',
            },
            confirmPassword: '',
            showPass: false,
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
        this.find();
        this.getRoles();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/users/find/' + this.id)
                .then(response => {
                    this.user = response.data.user;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        togglePassword() {
            this.showPass = !this.showPass;
        },
        validateEmail() {
            const emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            this.validEmail = emailPattern.test(this.user.email);
        },
        getRoles() {
            this.loading = true;
            axios.get('/admin/roles/list')
                .then(response => {
                    this.roles = response.data.roles.data;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        save() {
            const payload = {
                name: this.user.name,
                email: this.user.email,
                role_id: this.user.role_id,
            };
            if (this.user.password) {
                payload.password = this.user.password;
            }

            this.loading = true;
            axios.post('/admin/users/update/' + this.user.id, payload)
                .then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
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
                this.user.password = '';
                this.confirmPassword = '';
            }
        },
        passwordCheck() {
            if (this.user.password) {
                this.has_number = /\d/.test(this.user.password);
                this.has_lowercase = /[a-zA-Z]/.test(this.user.password);
                this.has_special = /[!@#\$%\^\&*\)\(+=._-]/.test(this.user.password);
                this.has_six_chars = this.user.password.length >= 6;
            }
        },
        showPassword() {
            this.inputPass = !this.inputPass;
        },
    }
}
</script>
