<template>
    <div class="container-fluid px-2" v-loading="{ show: loading }">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Editar Feedback</h5>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="save" autocomplete="off" class="mx-auto" style="max-width: 720px;">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Título</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                            <input id="title" type="text" class="form-control" v-model.trim="feedback.title"
                                placeholder="Resuma em uma frase" required maxlength="120" />
                        </div>
                        <div class="form-text d-flex justify-content-end">
                            {{ (feedback.title?.length || 0) }}/150
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="badge"
                                :class="feedback.status === 'open' ? 'text-bg-warning' : 'text-bg-success'">
                                {{ status() }}
                            </span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="statusSwitch"
                                    v-model="feedback.status" true-value="closed" false-value="open"
                                    @change="changeStatusName(feedback.status)" />
                                <!-- <label class="form-check-label" for="statusSwitch">
                                    {{ feedback.status === 'open' ? 'Aberto' : 'Fechado' }}
                                </label> -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Evidências</label>
                        <div v-if="urlImage || imageUrl" class="position-relative">
                            <div class="rounded border overflow-hidden" style="width: 200px; height: 150px;">
                                <img :src="urlImage || imageUrl" alt="Pré-visualização da evidência"
                                    class="w-100 h-100 object-fit-cover" />
                            </div>
                            <!-- <div class="d-flex gap-2 mt-2">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    @click="() => { urlImage = null; feedback.image_path = null; }">
                                    <i class="bi bi-trash"></i> Remover
                                </button>
                                <label class="btn btn-outline-secondary btn-sm mb-0">
                                    <i class="bi bi-arrow-repeat"></i> Trocar
                                    <input type="file" class="d-none" accept="image/*" @change="loadImage" />
                                </label>
                            </div> -->
                        </div>
                        <div v-else>
                            <input type="file" class="form-control" accept="image/*" @change="loadImage" />
                            <div class="form-text">PNG ou JPG até 5MB.</div>
                        </div>
                    </div>
                    <div class="mb-4 form-floating">
                        <textarea id="description" class="form-control" style="height: 140px"
                            v-model.trim="feedback.description"
                            placeholder="Descreva o problema, passos para reproduzir, etc."></textarea>
                        <label for="description">Descrição</label>
                    </div>
                    <div class="mb-2 text-muted small">
                        Criado por: <strong>{{ feedback.user?.name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <a :href="urlIndex" class="btn btn-outline-secondary  btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Atualizar
                        </button>
                    </div>
                </form>
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
                status: '',
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
        loadImage(e) {
            this.feedback.image_path = e.target.files[0];
            this.urlImage = URL.createObjectURL(this.feedback.image_path);
        },
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
        status() {
            if (this.feedback.status == 'open') {
                return 'Aberto';
            }
            if (this.feedback.status == 'closed') {
                return 'Fechado';
            }
        },
        save() {

        }
    }
}
</script>