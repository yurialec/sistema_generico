<template>
    <div v-if="loading" class="d-flex justify-content-center my-4">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <div v-else class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-4 col-12 text-start">
                    <h5 class="mb-0">Redes Sociais</h5>
                </div>
                <div class="col-md-5 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary" @click="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end text-start">
                    <a :href="urlCreateSocialMedia" type="button" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th class="col-md-3">Url</th>
                            <th class="col-md-3">Icone</th>
                            <th class="col-md-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="social in this.socialMedia.data">
                            <td class="col-md-3"><a style="text-decoration: none;" target="_blank" :href="social.url">{{
                                social.name }}</a></td>
                            <td class="col-md-3"><i :class="social.icon"></i></td>
                            <td class="col-md-3">
                                <a :href="urlEditSocialMedia.replace('_id', social.id)"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger me-1" @click="deleteRegister(social.id)">
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

export default {
    props: {
        urlCreateSocialMedia: String,
        urlEditSocialMedia: String,
    },
    data() {
        return {
            loading: false,
            searchFilter: '',
            socialMedia: [],
        };
    },
    mounted() {
        this.getSocialMedia();
    },
    methods: {
        search() {
            this.getSocialMedia('admin/site/social-media/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getSocialMedia(url);
            }
        },
        getSocialMedia() {
            this.loading = true;
            axios.get('admin/site/social-media/list')
                .then(response => {
                    this.socialMedia = response.data.socialMedia;
                })
                .catch(errors => {
                    this.alertStatus = 'error';
                }).finally(() => {
                    this.loading = false;
                });
        },
        deleteRegister() {
            this.confirmYesNo('Excluir registro?').then(() => {
                axios.delete('/admin/site/social-media/delete/' + id)
                    .then(response => {
                        this.getSocialMedia();
                        this.alertSuccess('Excluido com sucesso!');
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