<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Feedback</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" v-model="feedback.title">
                            </div>

                            <div class="mb-3">
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

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <small class="text-muted d-block mt-3">* Formulário placeholder (sem integração)</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            feedback: {
                title: '',
                description: '',
                image_path: '',
            },
            urlImage: null,
        }
    },
    methods: {
        loadImage(e) {
            this.feedback.image_path = e.target.files[0];
            this.urlImage = URL.createObjectURL(this.feedback.image_path);
        },
        save() {
            let formData = new FormData();

            if (this.feedback.image_path) {
                formData.append('image', this.feedback.image_path);
            }

            if (this.feedback.title) {
                formData.append('title', this.feedback.title);
            }

            if (this.feedback.description) {
                formData.append('description', this.feedback.description);
            }

            this.loading = true;
            axios.post('/admin/feedback/store', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(response => {
                this.alertSuccess('Operação realizada com sucesso!');
                this.clearForm();
            }).catch(errors => {
                this.alertDanger(errors);
            }).finally(() => {
                this.loading = false;
            });
        },
        clearForm() {
            this.feedback.title = '';
            this.feedback.description = '';
            this.feedback.image_path = '';
        }
    }
}
</script>