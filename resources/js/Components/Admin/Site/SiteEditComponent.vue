<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">Editar Site</h5>
                        <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body">
                        <ul class="nav justify-content-center mb-4">
                            <li v-for="(label, idx) in steps" :key="idx" class="mx-1">
                                <button class="btn rounded-pill px-3 py-1 fw-semibold" :class="step === idx ? 'btn-primary' : 'btn-outline-primary'" @click="step = idx">
                                    {{ idx + 1 }}
                                </button>
                            </li>
                        </ul>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-7">
                                <div v-if="step === 0">
                                    <h5 class="mb-3 fw-semibold">Sobre Nós</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" v-model="about.title">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control" v-model="about.description" rows="5"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Imagem</label>
                                        <input type="file" class="form-control" @change="handleImage($event, 'about')">
                                        <div class="text-center mt-3">
                                            <img :src="about.imagePreview || (about.oldImage ? `/storage/${about.oldImage}` : null)"
                                                v-if="about.imagePreview || about.oldImage" class="rounded border"
                                                style="max-width: 260px; max-height: 260px; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                                <div v-if="step === 1">
                                    <h5 class="mb-3 fw-semibold">Carrousel</h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Adicionar novas imagens</label>
                                        <input type="file" class="form-control" multiple @change="addCarouselImages">
                                    </div>
                                    <div class="row g-3 mt-3">
                                        <div v-for="img in carousel" :key="img.id || img.tempId"
                                            class="col-6 col-md-4 col-lg-3">
                                            <div class="position-relative">
                                                <button
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle"
                                                    @click="removeCarousel(img)"
                                                    style="z-index:10;width:26px;height:26px;display:flex;align-items:center;justify-content:center;">
                                                    ×
                                                </button>
                                                <img :src="img.preview || `/storage/${img.path}`"
                                                    class="img-fluid rounded border"
                                                    style="height:140px;object-fit:cover;width:100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="step === 2">
                                    <h5 class="mb-3 fw-semibold">Contato</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" class="form-control" v-model="contact.phone">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" v-model="contact.email">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Cidade</label>
                                            <input type="text" class="form-control" v-model="contact.city">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Estado</label>
                                            <input type="text" class="form-control" v-model="contact.state">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Endereço</label>
                                            <input type="text" class="form-control" v-model="contact.address">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">CEP</label>
                                            <input type="text" class="form-control" v-model="contact.zipcode">
                                        </div>
                                    </div>
                                </div>
                                <div v-if="step === 3">
                                    <h5 class="mb-3 fw-semibold">Logo</h5>
                                    <input type="file" class="form-control" @change="handleImage($event, 'logo')">
                                    <div class="text-center mt-3">
                                        <img :src="logo.imagePreview || (logo.oldImage ? `/storage/${logo.oldImage}` : null)"
                                            v-if="logo.imagePreview || logo.oldImage" class="rounded border"
                                            style="max-width:220px;max-height:220px;object-fit:contain;">
                                    </div>
                                </div>
                                <div v-if="step === 4">
                                    <h5 class="mb-3 fw-semibold">Texto Principal</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" v-model="main.title">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Texto</label>
                                        <textarea class="form-control" v-model="main.text" rows="3"></textarea>
                                    </div>
                                </div>
                                <div v-if="step === 5">
                                    <h5 class="mb-3 fw-semibold">Redes Sociais</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control" v-model="socialTemp.name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">URL</label>
                                        <input type="text" class="form-control" v-model="socialTemp.url">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control" v-model="socialTemp.icon">
                                    </div>
                                    <div class="text-center mb-3">
                                        <button class="btn btn-success btn-sm" @click="addSocial">Adicionar</button>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                            v-for="i in social" :key="i.tempId">
                                            <span><i :class="i.icon"></i> {{ i.name }} → {{ i.url }}</span>
                                            <button class="btn btn-danger btn-sm"
                                                @click="removeSocial(i.tempId)">Remover</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button class="btn btn-outline-primary" :disabled="step === 0" @click="step--">
                                        <i class="bi bi-chevron-left"></i> Anterior
                                    </button>
                                    <button v-if="step < steps.length - 1" class="btn btn-primary" @click="step++">
                                        Próximo <i class="bi bi-chevron-right"></i>
                                    </button>
                                    <button v-else class="btn btn-success" @click="save">
                                        <i class="bi bi-check-circle"></i> Salvar
                                    </button>
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
export default {
    props: { urlIndex: String },

    data() {
        return {
            step: 0,
            steps: [1, 2, 3, 4, 5, 6],
            about: {
                title: "",
                description: "",
                oldImage: null,
                image: null,
                imagePreview: null
            },
            carousel: [],
            contact: {
                phone: "",
                email: "",
                city: "",
                state: "",
                address: "",
                zipcode: ""
            },
            logo: {
                oldImage: null,
                image: null,
                imagePreview: null
            },
            main: {
                title: "",
                text: ""
            },
            socialTemp: {
                name: "",
                url: "",
                icon: ""
            },
            social: [],
        };
    },

    mounted() {
        this.find();
    },

    methods: {
        find() {
            axios.get('/admin/site/list')
                .then(response => {
                    this.about.title = response.data.items.about.title;
                    this.about.description = response.data.items.about.description;
                    this.about.oldImage = response.data.items.about.image;

                    this.carousel = response.data.items.carousel.map(img => ({
                        id: img.id,
                        path: img.image
                    }));

                    this.contact = response.data.items.contatct;
                    this.logo.oldImage = response.data.items.logo.image;
                    this.main = response.data.items.main;

                    this.social = response.data.items.socialMedia.map(s => ({
                        tempId: Date.now() + Math.random(),
                        name: s.name,
                        url: s.url,
                        icon: s.icon
                    }));

                })
                .catch(error => {
                    this.alertDanger(errors);
                });
        },
        handleImage(e, target) {
            const file = e.target.files[0];
            if (!file) return;

            const preview = URL.createObjectURL(file);

            if (target === 'about') {
                this.about.image = file;
                this.about.imagePreview = preview;
            }

            if (target === 'logo') {
                this.logo.image = file;
                this.logo.imagePreview = preview;
            }
        },
        addCarouselImages(e) {
            const files = Array.from(e.target.files);

            files.forEach(file => {
                this.carousel.push({
                    tempId: Date.now() + Math.random(),
                    file,
                    preview: URL.createObjectURL(file)
                });
            });
        },
        removeCarousel(img) {
            this.carousel = this.carousel.filter(i => i !== img);
        },
        addSocial() {
            if (!this.socialTemp.name || !this.socialTemp.url) return;

            this.social.push({
                tempId: Date.now(),
                ...this.socialTemp
            });

            this.socialTemp = { name: "", url: "", icon: "" };
        },
        removeSocial(id) {
            this.social = this.social.filter(s => s.tempId !== id);
        },
        save() {

            const form = new FormData();


            form.append("about_title", this.about.title);
            form.append("about_description", this.about.description);
            if (this.about.image) form.append("about_image", this.about.image);

            if (this.logo.image) form.append("logo_image", this.logo.image);

            Object.entries(this.contact).forEach(([k, v]) => {
                form.append(`contact_${k}`, v);
            });

            form.append("main_title", this.main.title);
            form.append("main_text", this.main.text);

            this.carousel.forEach(img => {
                if (img.file) {
                    form.append("carousel_new[]", img.file);
                } else {
                    form.append("carousel_old[]", img.id);
                }
            });

            form.append("social", JSON.stringify(this.social));

            axios.post('/admin/site/save', form)
                .then(response => {
                    this.alertSuccess('Operação realizada com sucesso!');
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>