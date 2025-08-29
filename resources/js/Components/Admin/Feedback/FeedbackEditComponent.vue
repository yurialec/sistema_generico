<template>
    <div class="container-fluid px-2" v-loading="{ show: loading }">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar Feedback</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" v-model="feedback.title">
                            </div>

                            <div class="mb-3" v-if="feedback.image_path">
                                <label class="form-label">Evidência</label>
                                <img class="form-control h-50 w-50 mb-3 mx-auto d-block" :src="imageUrl" />
                            </div>
                            <div v-else>
                                <label class="form-label">Evidência</label>
                                <input type="file" class="form-control mb-3" @change="loadImage">
                                <img v-if="urlImage" class="form-control h-50 w-50 mb-3  mx-auto d-block"
                                    :src="urlImage">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" v-model="feedback.description" rows="5">
                                </textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Criado por: {{ feedback.user.name }}</label>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
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
export default {
    props: {
        id: [String, Number],
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            feedback: {
                title: '',
                description: '',
                image_path: '',
                user: {
                    name: '',
                }
            },
            urlImage: null,
        }
    },
    computed: {
        imageUrl() {
            const p = this.feedback?.image_path || '';
            if (!p) return '';
            return p.startsWith('/storage/') ? p : `/storage/${p}`;
        }
    },
    mounted() {
        this.find();
    },
    methods: {
        find() {
            this.loading = true;
            axios.get('/admin/feedback/find/' + this.id)
                .then(response => {
                    this.feedback = response.data.item;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        },
        loadImage(e) {
            this.feedback.image_path = e.target.files[0];
            this.urlImage = URL.createObjectURL(this.feedback.image_path);
        },
        save() {

        }
    }
}
</script>