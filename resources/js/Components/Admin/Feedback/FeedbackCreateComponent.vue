<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Feedback</h5>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form @submit.prevent="save" autocomplete="off" novalidate>
                            <!-- Título -->
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" v-model.trim="feedback.title" />
                            </div>

                            <!-- Evidências de Arquivo (imagens/PDFs) -->
                            <div class="mb-3">
                                <label class="form-label">Evidências (imagens/PDFs)</label>
                                <!-- <input type="file" class="form-control" multiple :disabled="loading"
                                    accept=".png,.jpg,.jpeg,.gif,.webp,.pdf" @change="onFilesChange" /> -->
                                <div v-if="filePreviews.length" class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-6 col-md-4" v-for="(item, idx) in filePreviews" :key="idx">
                                            <div
                                                class="border rounded p-2 h-100 d-flex flex-column align-items-center text-center">
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
                            </div>

                            <!-- Evidências de Texto -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Evidências</label>
                                    <div>
                                        <!-- Botão para anexar outros arquivos -->
                                        <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                            @click="$refs.fileInput.click()" :disabled="loading">
                                            + Anexar Arquivo
                                        </button>

                                        <!-- Botão para adicionar evidência de texto -->
                                        <!-- <button type="button" class="btn btn-outline-secondary btn-sm"
                                            @click="addTextEvidence" :disabled="loading">
                                            + Evidência Texto
                                        </button> -->
                                    </div>
                                </div>

                                <!-- Input escondido para arquivos -->
                                <input type="file" ref="fileInput" class="d-none" multiple
                                    accept=".png,.jpg,.jpeg,.gif,.webp,.pdf" @change="onFilesChange" />

                                <div v-if="textEvidences.length === 0" class="text-muted small">
                                    (opcional) Adicione trechos de logs, passos para reproduzir, links, etc.
                                </div>

                                <div v-for="(text, i) in textEvidences" :key="'t' + i" class="mb-2">
                                    <div class="input-group">
                                        <textarea class="form-control" rows="2" v-model.trim="textEvidences[i]"
                                            :placeholder="`Evidência de texto #${i + 1}`"
                                            :disabled="loading"></textarea>
                                        <button type="button" class="btn btn-outline-danger"
                                            @click="removeTextEvidence(i)" :disabled="loading">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" v-model.trim="feedback.description" rows="5"></textarea>
                            </div>

                            <!-- Ações -->
                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" :disabled="loading">
                                    <span v-if="!loading">Salvar</span>
                                    <span v-else class="spinner-border spinner-border-sm"></span>
                                </button>
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
        urlIndex: String,
    },
    data() {
        return {
            loading: false,
            feedback: {
                title: '',
                description: '',
            },
            // evidências de arquivo (File[])
            files: [],
            // previews auxiliares [{kind: 'image'|'pdf', url?, name}]
            filePreviews: [],
            // evidências de texto (string[])
            textEvidences: [],
        };
    },
    methods: {
        onFilesChange(e) {
            const selected = Array.from(e.target.files || []);
            // concatena para permitir múltiplos selects
            this.files = this.files.concat(selected);

            // atualiza previews
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
                    // ignora formatos não permitidos (defensivo)
                    return;
                }
                this.filePreviews.push(item);
            });

            // limpa input para permitir re-seleção do mesmo arquivo
            e.target.value = '';
        },

        removeFile(idx) {
            // revoga URL se imagem
            const preview = this.filePreviews[idx];
            if (preview?.kind === 'image' && preview.url) {
                URL.revokeObjectURL(preview.url);
            }
            this.filePreviews.splice(idx, 1);
            this.files.splice(idx, 1);
        },

        addTextEvidence() {
            this.textEvidences.push('');
        },

        removeTextEvidence(index) {
            this.textEvidences.splice(index, 1);
        },

        async save() {
            // validação simples
            if (!this.feedback.title?.trim()) {
                return this.alertDanger('Informe o título.');
            }
            if (!this.feedback.description?.trim()) {
                return this.alertDanger('Informe a descrição.');
            }

            const formData = new FormData();
            formData.append('title', this.feedback.title);
            formData.append('description', this.feedback.description);

            // arquivos: evidences_files[]
            this.files.forEach((file) => {
                formData.append('evidences_files[]', file);
            });

            // textos: evidences_text[]
            // this.textEvidences
            //     .filter((t) => t && t.trim().length > 0)
            //     .forEach((t) => formData.append('evidences_text[]', t.trim()));

            this.loading = true;
            try {
                await axios.post('/admin/feedback/store', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                this.alertSuccess('Operação realizada com sucesso!');
                this.clearForm();
            } catch (err) {
                this.alertDanger(err);
            } finally {
                this.loading = false;
            }
        },

        clearForm() {
            // revoga URLs
            this.filePreviews.forEach((p) => {
                if (p.kind === 'image' && p.url) URL.revokeObjectURL(p.url);
            });

            this.feedback.title = '';
            this.feedback.description = '';
            this.files = [];
            this.filePreviews = [];
            this.textEvidences = [];
        }
    },
    beforeUnmount() {
        // limpeza defensiva das URLs
        this.filePreviews.forEach((p) => {
            if (p.kind === 'image' && p.url) URL.revokeObjectURL(p.url);
        });
    },
};
</script>
