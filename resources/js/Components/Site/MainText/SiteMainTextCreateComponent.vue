<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Conteúdo Principal</h5>
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
                            <div class="mb-3">
                                <label class="form-label">Titulo</label>
                                <input type="text" class="form-control" v-model="main.title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto</label>
                                <textarea class="form-control" rows="5" v-model="main.text"></textarea>
                                <small v-show="main.text.length > 255" class="text-danger">
                                    <strong>Você atingiu o máximo de caracteres.</strong>
                                </small>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndexMainText" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
        urlIndexMainText: String,
    },
    data() {
        return {
            loading: false,
            main: {
                title: '',
                text: '',
            },
        };
    },
    methods: {
        save() {

            if (this.main.text.length > 255) {
                this.alertDanger('O campo Texto deve conter no máximo 255 caracteres.');
                return;
            }

            this.loading = true;
            axios.post('/admin/site/main-text/store', this.main)
                .then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
                    window.location.href = this.urlIndexMainText;
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
