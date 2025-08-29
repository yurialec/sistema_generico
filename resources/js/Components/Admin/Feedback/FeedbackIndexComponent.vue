<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">Feedback</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter"
                            placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary" @click="search()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12 text-md-end">
                    <a :href="urlCreate" class="btn btn-sm btn-success">
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
                            <th>#</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Preview</th>
                            <th>Status</th>
                            <th>Usuário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="feedback in feedbacks.data" :key="feedback.id">
                            <td>{{ feedback.id }}</td>
                            <td>{{ feedback.title }}</td>
                            <td class="text-truncate" style="max-width: 200px;">
                                {{ feedback.description }}
                            </td>
                            <td>
                                <div v-if="feedback.image_path">
                                    <img :src="'/storage/' + feedback.image_path" width="80">
                                </div>
                            </td>
                            <td>
                                <span :class="`badge text-bg-${feedback.status === 'open' ? 'warning' : 'success'}`">
                                    {{ status(feedback.status) }}
                                </span>
                            </td>
                            <td>{{ feedback.user.name }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="bi bi-eye me-2"></i> Visualizar
                                            </a>
                                        </li>
                                        <li>
                                            <a v-if="feedback.status === 'open'" class="dropdown-item"
                                                :href="urlEdit.replace('_id', feedback.id)">
                                                <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                            </a>
                                        </li>
                                        <li v-if="feedback.status === 'open'">
                                            <button class="dropdown-item" @click="changeStatus(feedback.id)">
                                                <i class="bi bi-check2-circle text-success me-2"></i> Marcar como feito
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
            <nav v-if="feedbacks.links.length > 0">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li v-for="(link, i) in feedbacks.links" :key="i"
                        :class="['page-item', { active: link.active, disabled: !link.url }]">
                        <a class="page-link" href="#" v-html="link.label" @click.prevent="pagination(link.url)"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlCreate: String,
        urlEdit: String,
        urlShow: String,
    },
    data() {
        return {
            loading: false,
            searchFilter: '',
            feedbacks: {
                data: [],
                links: []
            },
        }
    },
    mounted() {
        this.getFeedbacks();
    },
    methods: {
        search() {
            this.getFeedbacks('admin/feedback/list', this.searchFilter);
        },
        pagination(url) {
            if (url) {
                this.getFeedbacks(url);
            }
        },
        getFeedbacks(url = 'admin/feedback/list', term = '') {            
            this.loading = true;
            axios.post(url, { term })
                .then(response => {
                    this.feedbacks = response.data.items;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        status(status) {
            switch (status) {
                case 'done':
                    return 'Feito'
                    break;
                default:
                    return 'Aberto'
                    break;
            }
        },
        changeStatus(feedback) {

            console.log(feedback);

        }
    }
}
</script>