<template>
    <div v-if="loading" class="d-flex justify-content-center my-4">
        <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
    <div v-else class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">Blog</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary" @click="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreateBlog" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Autor</th>
                            <th scope="col" class="text-center" style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="blog in blogs.data" :key="blog.id">
                            <td>{{ blog.title }}</td>
                            <td class="text-truncate" style="max-width: 300px;">{{ blog.description }}</td>
                            <td>
                                <div>{{ blog.user.name }}</div>
                                <small class="text-muted">{{ blog.user.email }}</small>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1"
                                    @click="viewImage(blog)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a :href="urlEditBlog.replace('_id', blog.id)"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    @click="deleteRegister(blog.id)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
            <nav v-if="blogs.links.length > 0">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in blogs.links" :key="i"
                        :class="['page-item', { active: link.active, disabled: !link.url }]">
                        <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewImgModal" tabindex="-1" aria-labelledby="viewImgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewImgModalLabel">Visualizar imagen do blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            <div v-for="(image, index) in selectedBlog" :key="index"
                                :class="['carousel-item', { active: index === 0 }]">
                                <img :src="'/storage/' + image.image_path" class="d-block w-100 h-30 mb-4" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span style="background-color: #333; border-radius: 10px;"
                                class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span style="background-color: #333; border-radius: 10px;"
                                class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Carousel } from 'bootstrap';

export default {
    props: {
        urlCreateBlog: String,
        urlEditBlog: String,
    },
    data() {
        return {
            loading: false,
            blogs: {
                data: [],
                links: []
            },
            selectedBlog: {},
            searchFilter: null,
        };
    },
    mounted() {
        this.getBlog();
    },
    methods: {
        search() {
            this.getBlog('admin/blog/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getBlog(url);
            }
        },
        getBlog(url = 'admin/blog/list') {
            this.loading = true;
            axios.get(url)
                .then(response => {
                    this.blogs = response.data.blogs;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        deleteRegister(id) {
            this.confirmYesNo('Tem certeza que deseja excluir?').then(() => {
                axios.delete('/admin/blog/delete/' + id)
                    .then(response => {
                        this.getBlog();
                        this.alertSuccess('Excluido com sucesso!');
                    })
                    .catch(errors => {
                        this.alertDanger(errors);
                    }).finally(() => {
                        this.loading = false;
                    });
            });
        },
        viewImage(blog) {
            this.selectedBlog = blog.images;
            this.$nextTick(() => {
                const carouselElement = document.getElementById('carouselExample');
                const carousel = Carousel.getOrCreateInstance(carouselElement);
                carousel.to(0);
            });
        }
    }
}
</script>
