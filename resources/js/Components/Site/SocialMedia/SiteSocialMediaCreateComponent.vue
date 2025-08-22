<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="mb-0">Cadastrar Rede Social</h5>
                        </div>
                        <div class="col-sm text-end">
                            <a href="https://icons.getbootstrap.com/" target="_blank" class="me-2">Biblioteca de
                                ícones</a>
                            <i class="bi bi-info-circle fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
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
                                <input type="text" required class="form-control" v-model="media.name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Icone</label>
                                <input type="text" required class="form-control" v-model="media.icon">
                                <small class="text-muted">Ao adicionar o ícone, você deve remover as tags HTML</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="text" required class="form-control" v-model="media.url">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexSocialMedia" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexSocialMedia: String,
    },
    data() {
        return {
            loading: false,
            media: {
                name: '',
                icon: '',
                url: '',
            },
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios.post('/admin/site/social-media/store', this.media)
                .then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
                    this.clearForm();
                })
                .catch(err => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clearForm() {
            this.media.name = '';
            this.media.icon = '';
            this.media.url = '';
        }
    }
}
</script>
