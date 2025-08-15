<template>
    <div v-if="loading" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <div v-else class="card shadow-sm border-0">
        <div class="card-header py-3 bg-light">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h5 class="mb-0">Informações Contato</h5>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <a v-if="!contact?.id" :href="urlCreateContact" type="button" class="btn btn-sm btn-success"><i
                            class="bi bi-plus-circle me-1"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="col-md-1">Telefone</th>
                            <th class="col-md-1">E-mail</th>
                            <th class="col-md-1">Cidade</th>
                            <th class="col-md-1">UF</th>
                            <th class="col-md-3">Endereço</th>
                            <th class="col-md-1">CEP</th>
                            <th class="col-md-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="contact">
                            <td class="col-md-1">{{ contact.phone }}</td>
                            <td class="col-md-1">{{ contact.email }}</td>
                            <td class="col-md-1">{{ contact.city }}</td>
                            <td class="col-md-1">{{ contact.state }}</td>
                            <td class="col-md-3">{{ contact.address }}</td>
                            <td class="col-md-1">{{ contact.zipcode }}</td>
                            <td class="col-md-1">
                                <a :href="'/admin/site/contact/edit/' + contact.id">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn" @click="deleteRecord(contact.id)">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreateContact: String,
    },
    data() {
        return {
            loading: false,
            contact: [],
        };
    },
    mounted() {
        this.getContact();
    },
    methods: {
        getContact() {
            this.loading = true;
            axios.get('admin/site/contact/list')
                .then(response => {
                    this.contact = response.data.contact;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        deleteRecord(id) {
            this.confirmYesNo('Deseja excluir o conteúdo?').then(() => {
                axios.delete('/admin/site/contact/delete/' + id)
                    .then(response => {
                        this.getContact();
                        this.alertSuccess('Operação realizada com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
    }
}
</script>
