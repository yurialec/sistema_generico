<template>
    <div class="container py-4" v-loading="{ show: loading }">
        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Editar Feedback
                </h5>
                <span v-if="feedback.status"
                    :class="['badge', feedback.status === 'done' ? 'bg-success' : 'bg-warning text-dark']">
                    {{ feedback.status }}
                </span>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="save" autocomplete="off" class="mx-auto" style="max-width: 720px">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Título</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-pen"></i>
                            </span>
                            <input id="title" type="text" class="form-control" v-model.trim="feedback.title"
                                placeholder="Resuma em uma frase" required maxlength="150"
                                :disabled="feedback.status === 'done'" />
                        </div>
                        <small class="form-text text-muted d-flex justify-content-end">
                            {{ (feedback.title?.length || 0) }}/150
                        </small>
                    </div>
                    <div class="mb-4">
                        <label for="statusSwitch" class="form-label fw-semibold d-block">Status</label>
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                            <span class="text-secondary small">
                                {{ feedback.status === 'done' ? 'Concluído' : 'Aberto' }}
                            </span>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" id="statusSwitch"
                                    v-model="feedback.status" true-value="done" false-value="open"
                                    :disabled="canEdit" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">Evidências</label>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                    @click="$refs.fileInput.click()" :disabled="canEdit">
                                    + Anexar Arquivo
                                </button>
                                <input class="d-none" type="file" ref="fileInput" multiple
                                    accept=".png,.jpg,.jpeg,.gif,.webp,.pdf" @change="onFilesChange" />
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3" v-for="(img, i) in feedback.evidences" :key="i">
                            <div class="border rounded overflow-hidden shadow-sm position-relative">
                                <template v-if="img.type === 'pdf'">
                                    <div class="d-flex flex-column justify-content-center align-items-center p-3">
                                        <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                                        <small class="text-truncate">{{ img.original_name }}</small>
                                    </div>
                                </template>
                                <template v-else-if="img.type === 'image'">
                                    <img :src="'/storage/' + img.path" class="img-fluid object-fit-cover"
                                        style="aspect-ratio: 1/1" />
                                </template>

                                <div class="p-2 text-center border-top bg-light">
                                    <a :href="`/admin/feedback/evidence/${img.id}/download`"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-download"></i> Baixar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2" v-if="filePreviews.length">
                            <div class="col-6 col-md-4 col-lg-3" v-for="(item, idx) in filePreviews" :key="'new' + idx">
                                <div class="border rounded p-2 h-100 d-flex flex-column align-items-center text-center">
                                    <template v-if="item.kind === 'image'">
                                        <img :src="item.url" class="img-fluid rounded mb-2" alt="preview" />
                                        <small class="text-truncate w-100">{{ item.name }}</small>
                                    </template>
                                    <template v-else>
                                        <i class="bi bi-file-earmark-pdf fs-1 mb-1"></i>
                                        <small class="text-truncate w-100">{{ item.name }}</small>
                                    </template>
                                    <button type="button" class="btn btn-outline-danger btn-xs mt-2"
                                        @click="removeFile(idx)">
                                        Remover
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 form-floating">
                        <textarea id="description" class="form-control" style="height: 150px"
                            v-model.trim="feedback.description" :disabled="feedback.status === 'done'"
                            placeholder="Descreva o problema, passos para reproduzir, etc."></textarea>
                        <label for="description">Descrição</label>
                    </div>
                    <div class="mb-3 text-muted small">
                        <i class="bi bi-person-circle me-1"></i>
                        Criado por: <strong>{{ feedback.user.name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="canEdit || loading">
                            <span v-if="!loading">
                                <i class="bi bi-save me-1"></i> Atualizar
                            </span>
                            <span v-else class="spinner-border spinner-border-sm"></span>
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
                evidences: [],
                status: '',
                user: { name: '' },
            },
            files: [],
            filePreviews: [],
            canEdit: false,
        };
    },
    computed: {
        imageUrl() {
            return this.feedback.evidences?.map((e) => e.path) || [];
        },
    },
    mounted() {
        this.find();
    },
    methods: {
        async find() {
            this.loading = true;
            try {
                const { data } = await axios.get(`/admin/feedback/find/${this.id}`);
                this.feedback = data.item;
                this.canEdit = this.feedback.status === 'done';
            } catch (err) {
                this.alertDanger(err);
            } finally {
                this.loading = false;
            }
        },
        onFilesChange(e) {
            const selected = Array.from(e.target.files || []);
            this.files = this.files.concat(selected);

            selected.forEach((file) => {
                const isImage = file.type.startsWith('image/');
                const isPdf = file.type === 'application/pdf';
                const item = { name: file.name };

                if (isImage) {
                    item.kind = 'image';
                    item.url = URL.createObjectURL(file);
                } else if (isPdf) {
                    item.kind = 'pdf';
                } else {
                    return;
                }

                this.filePreviews.push(item);
            });

            e.target.value = '';
        },
        removeFile(idx) {
            const preview = this.filePreviews[idx];
            if (preview?.kind === 'image' && preview.url) {
                URL.revokeObjectURL(preview.url);
            }
            this.filePreviews.splice(idx, 1);
            this.files.splice(idx, 1);
        },
        async save() {
            if (!this.feedback.title?.trim()) {
                return this.alertDanger('Informe o título.');
            }
            if (!this.feedback.description?.trim()) {
                return this.alertDanger('Informe a descrição.');
            }

            const formData = new FormData();
            formData.append('title', this.feedback.title);
            formData.append('description', this.feedback.description);
            formData.append('status', this.feedback.status);

            this.files.forEach((file) => {
                formData.append('evidences_files[]', file);
            });

            this.loading = true;
            try {
                await axios.post(`/admin/feedback/update/${this.id}`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                this.alertSuccess('Feedback atualizado com sucesso!');
                this.find();
                this.filePreviews = [];
                this.files = [];
            } catch (err) {
                this.alertDanger(err);
            } finally {
                this.loading = false;
            }
        },
    },
    beforeUnmount() {
        this.filePreviews.forEach((p) => {
            if (p.kind === 'image' && p.url) URL.revokeObjectURL(p.url);
        });
    },
};
</script>
