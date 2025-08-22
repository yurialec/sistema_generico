<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Editar Informações Contato</h5>
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
                            <div v-if="loadingZip" class="d-flex justify-content-center">
                                <button class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </div>
                            <div v-else>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">CEP</label>
                                            <input type="text" class="form-control" @keyup="searchCep()"
                                                v-model="contact.zipcode" v-mask="'#####-###'" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Estado</label>
                                            <select class="form-select" v-model="contact.state">
                                                <option v-for="(name, abbreviation) in states" :key="abbreviation"
                                                    :value="abbreviation">
                                                    {{ name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Endereço</label>
                                            <input type="text" class="form-control" v-model="contact.address"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" class="form-control" v-model="contact.phone"
                                                @input="validatePhone" maxlength="11" autocomplete="off">
                                            <small v-if="validPhone === false" class="text-danger">
                                                Telefone inválido
                                            </small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <input type="email" class="form-control" v-model="contact.email"
                                                @input="validateEmail" autocomplete="off">
                                            <small v-if="validEmail === false" class="text-danger">
                                                E-mail inválido
                                            </small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cidade</label>
                                            <input type="text" class="form-control" v-model="contact.city"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexContact" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Editar</button>
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
        urlIndexContact: String,
    },
    data() {
        return {
            loading: false,
            loadingZip: false,
            contact: {},
            dataZipCode: null,
            validPhone: null,
            validEmail: null,
            validZipCode: null,
            states: {
                'AC': 'Acre',
                'AL': 'Alagoas',
                'AP': 'Amapá',
                'AM': 'Amazonas',
                'BA': 'Bahia',
                'CE': 'Ceará',
                'DF': 'Distrito Federal',
                'ES': 'Espírito Santo',
                'GO': 'Goiás',
                'MA': 'Maranhão',
                'MT': 'Mato Grosso',
                'MS': 'Mato Grosso do Sul',
                'MG': 'Minas Gerais',
                'PA': 'Pará',
                'PB': 'Paraíba',
                'PR': 'Paraná',
                'PE': 'Pernambuco',
                'PI': 'Piauí',
                'RJ': 'Rio de Janeiro',
                'RN': 'Rio Grande do Norte',
                'RS': 'Rio Grande do Sul',
                'RO': 'Rondônia',
                'RR': 'Roraima',
                'SC': 'Santa Catarina',
                'SP': 'São Paulo',
                'SE': 'Sergipe',
                'TO': 'Tocantins'
            },
        };
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            axios.get(`/admin/site/contact/find/${this.id}`)
                .then(response => {
                    this.contact = response.data.contact;
                }).catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        searchCep() {
            let zip = this.contact.zipcode.replace(/[^a-zA-Z0-9 ]/g, '');
            if (zip.length == 8) {
                this.loadingZip = true;
                axios.get('cep/' + this.contact.zipcode)
                    .then(response => {
                        this.dataZipCode = response.data;
                        if (this.dataZipCode) {
                            this.contact.city = this.dataZipCode.localidade
                            this.contact.state = this.dataZipCode.uf
                            this.contact.address = this.dataZipCode.logradouro
                            this.contact.zipcode = this.dataZipCode.cep
                        }
                    }).catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loadingZip = false;
                    });
            }
        },
        validateEmail() {
            const emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            this.validEmail = emailPattern.test(this.contact.email);
        },
        validatePhone() {

            this.validPhone = true;
            this.contact.phone = this.contact.phone.replace(/\D/g, '');

            if (!(this.contact.phone.length >= 10 && this.contact.phone.length <= 11)) {
                this.validPhone = false;
                return;
            }

            if (this.contact.phone.length === 11 && parseInt(this.contact.phone.substring(2, 3)) !== 9) {
                this.validPhone = false;
                return;
            }

            for (var n = 0; n < 10; n++) {
                if (this.contact.phone == new Array(11).join(n) || this.contact.phone == new Array(12).join(n)) this.validPhone = false;
            }

            var codigosDDD = [11, 12, 13, 14, 15, 16, 17, 18, 19,
                21, 22, 24, 27, 28, 31, 32, 33, 34,
                35, 37, 38, 41, 42, 43, 44, 45, 46,
                47, 48, 49, 51, 53, 54, 55, 61, 62,
                64, 63, 65, 66, 67, 68, 69, 71, 73,
                74, 75, 77, 79, 81, 82, 83, 84, 85,
                86, 87, 88, 89, 91, 92, 93, 94, 95,
                96, 97, 98, 99];

            if (codigosDDD.indexOf(parseInt(this.contact.phone.substring(0, 2))) == -1) this.validPhone = false;

            if (new Date().getFullYear() < 2017) this.validPhone = true;
            if (this.contact.phone.length == 10 && [2, 3, 4, 5, 7].indexOf(parseInt(this.contact.phone.substring(2, 3))) == -1) this.validPhone = false;

            if (!this.validPhone) return;
        },
        save() {
            let formData = new FormData();

            if (this.contact.phone) {
                formData.append('phone', this.contact.phone);
            }
            if (this.contact.email) {
                formData.append('email', this.contact.email);
            }
            if (this.contact.city) {
                formData.append('city', this.contact.city);
            }
            if (this.contact.state) {
                formData.append('state', this.contact.state);
            }
            if (this.contact.address) {
                formData.append('address', this.contact.address);
            }

            let zip = this.contact.zipcode.replace(/[^a-zA-Z0-9 ]/g, '');
            if (zip) {
                formData.append('zipcode', zip);
            }

            this.loading = true;
            axios.post(`/admin/site/contact/update/${this.id}`, formData)
                .then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
    }
}
</script>
