<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar usuário</h5>
            </div>
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
            <div v-else class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" v-model="user.name" required autocomplete="off">
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
                            <div class="mb-3">
                                <label class="form-label">Perfil</label>
                                <select class="form-select" v-model="user.role_id" required>
                                    <option value="" disabled>Selecione um perfil</option>
                                    <option v-for="role in roles" :value="role.id" :key="role.id">{{ role.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="row">
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
        urlIndexUser: String,
    },
    data() {
        return {
            loading: false,
            alertStatus: null,
            validEmail: null,
            confirmPassword: '',
            showPass: false,
            user: {
                name: '',
                email: '',
                password: '',
                role_id: ''
            },
            roles: [],
            messages: {},
            has_number: false,
            has_lowercase: false,
            has_special: false,
            has_six_chars: false,
        };
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        togglePassword() {
            this.showPass = !this.showPass;
        },
        validateEmail() {
            const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
            this.validEmail = pattern.test(this.user.email);
        },
        getRoles() {
            this.loading = true;
            axios.get('/admin/roles/list')
                .then(response => {
                    this.roles = response.data.roles.data;
                })
                .catch(() => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        passwordCheck() {
            const password = this.user.password;
            this.has_number = /\d/.test(password);
            this.has_lowercase = /[a-zA-Z]/.test(password);
            this.has_special = /[!@#\$%\^\&*\)\(+=._-]/.test(password);
            this.has_six_chars = password.length >= 6;
        },
        save() {
            if (this.user.password !== this.confirmPassword) {
                this.alertStatus = false;
                this.messages = { data: { errors: [['As senhas não coincidem.']] } };
                return;
            }

            axios.post('/admin/users/store', this.user)
                .then(res => {
                    this.alertSuccess('Operação realizada com sucesso!');
                    window.scrollTo(0, 0);
                    this.clearForm();
                })
                .catch(err => {
                    this.alertDanger(errors);
                    window.scrollTo(0, 0);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.user = { name: '', email: '', password: '', role_id: '' };
            this.confirmPassword = '';
            this.validEmail = null;
        }
    }
}
</script>