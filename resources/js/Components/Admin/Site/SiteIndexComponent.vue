<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-loading="{ show: loading }">
                    <div class="card-body">
                        <div class="row">
                            <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <a :href="urlEdit" class="btn btn-success btn-sm">
                                        Editar
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Conteúdo Principal</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="mb-1">
                                        <strong>Título:</strong>
                                        <span>{{ main.title }}</span>
                                    </div>
                                    <div>
                                        <strong>Texto:</strong>
                                        <span>{{ main.text }}</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Sobre</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="mb-1">
                                        <strong>Título:</strong>
                                        <span>{{ about.title }}</span>
                                    </div>
                                    <div>
                                        <strong>Descrição:</strong>
                                        <span>{{ about.description }}</span>
                                    </div>
                                    <div>
                                        <strong>Imagem</strong>
                                        <img :src="`/storage/${about.image}`" class="d-block rounded" width="200"
                                            height="200">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Contato</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <dl class="row mb-2">
                                        <dt class="col-sm-3">Telefone:</dt>
                                        <dd class="col-sm-9">{{ contact.phone }}</dd>

                                        <dt class="col-sm-3">E-mail:</dt>
                                        <dd class="col-sm-9">{{ contact.email }}</dd>
                                    </dl>
                                    <dl class="row mb-2">
                                        <dt class="col-sm-3">Cidade:</dt>
                                        <dd class="col-sm-9">{{ contact.city }}/{{ contact.state }}</dd>

                                        <dt class="col-sm-3">Endereço:</dt>
                                        <dd class="col-sm-9">{{ contact.address }}</dd>
                                    </dl>
                                    <dl class="row mb-2">
                                        <dt class="col-sm-3">CEP:</dt>
                                        <dd class="col-sm-9">{{ contact.zipcode }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Carousel</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="mb-1">
                                        <div id="carouselExample" class="carousel slide d-flex justify-content-center">
                                            <div class="carousel-inner">
                                                <div class="carousel-item" v-for="(item, index) in carousel"
                                                    :key="item.id" :class="{ active: index === 0 }">
                                                    <img :src="`/storage/${item.image}`" :alt="`Imagem ${index + 1}`"
                                                        class="d-block rounded shadow-sm"
                                                        style="width: 200px; height: 200px; object-fit: cover;">
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExample" data-bs-slide="prev">
                                                <span
                                                    class="carousel-control-prev-icon bg-primary p-2 rounded-circle small-control"></span>
                                                <span class="visually-hidden">Anterior</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExample" data-bs-slide="next">
                                                <span
                                                    class="carousel-control-next-icon bg-primary p-2 rounded-circle small-control"></span>
                                                <span class="visually-hidden">Próximo</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Logo</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <img :src="`/storage/${logo.image}`" class="d-block rounded" width="400"
                                        height="200">
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <h6 class="fw-bold mb-2">Redes Sociais</h6>
                                </div>
                                <div class="col-12 col-md-8">
                                    <ul class="list-unstyled mb-0">
                                        <li v-for="item in socialMedia" :key="item.id"
                                            class="mb-2 d-flex align-items-center">
                                            <i :class="item.icon + ' fs-5 me-2 text-primary'"></i>
                                            <a :href="item.url" target="_blank" class="text-decoration-none">
                                                {{ item.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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
        urlCreate: String,
        urlEdit: String,
    },
    data() {
        return {
            loading: false,
            main: {},
            about: {},
            carousel: {},
            contact: {},
            logo: {},
            socialMedia: {},
        }
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/site/list')
                .then(response => {
                    this.main = response.data.items.main;
                    this.about = response.data.items.about;
                    this.carousel = response.data.items.carousel;
                    this.contact = response.data.items.contatct;
                    this.logo = response.data.items.logo;
                    this.socialMedia = response.data.items.socialMedia;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>
<style>
.small-control {
    width: 24px !important;
    height: 24px !important;
    background-size: 60% 60%;
}
</style>