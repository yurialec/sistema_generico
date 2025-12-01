<template>
    <div class="container-fluid px-2">
        <div class="card shadow-sm">

            <!-- Cabeçalho -->
            <div class="card-header bg-light">
                <h5 class="mb-0">Cadastrar Site</h5>
            </div>

            <div class="card-body">

                <!-- Navegação das etapas -->
                <ul class="nav nav-pills mb-4 justify-content-center">
                    <li class="nav-item" v-for="(s, idx) in steps" :key="idx">
                        <button class="nav-link rounded-circle me-2" :class="{ active: step === idx }" @click="step = idx">
                            {{ s }}
                        </button>
                    </li>
                </ul>

                <!-- Conteúdo das etapas -->
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">

                        <!-- ====================== STEP 1 - ABOUT ====================== -->
                        <form v-if="step === 0" @submit.prevent="saveAbout" autocomplete="off">

                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" placeholder="—" v-model="about.title">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control" placeholder="—" v-model="about.description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" @change="handleImage($event, 'about')">
                            </div>

                            <ActionButtons :urlIndex="urlIndex" />
                        </form>

                        <!-- ====================== STEP 2 - CARROUSEL ====================== -->
                        <form v-if="step === 1" @submit.prevent="addCarrousel">

                            <div class="mb-3">
                                <label class="form-label">Imagem do Carrossel</label>
                                <input type="file" class="form-control" @change="handleImage($event, 'carrouselTemp')">
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Adicionar</button>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 col-md-4 mb-3" v-for="img in carrousel" :key="img.tempId">
                                    <div class="card">
                                        <img :src="img.preview" class="card-img-top">
                                        <div class="card-body text-center">
                                            <button class="btn btn-danger btn-sm"
                                                @click="removeCarrousel(img.tempId)">Remover</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ActionButtons :urlIndex="urlIndex" saveDisabled />
                        </form>

                        <!-- ====================== STEP 3 - CONTACT ====================== -->
                        <form v-if="step === 2" @submit.prevent="saveContact">

                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.phone">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.city">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.state">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.address">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CEP</label>
                                <input type="text" class="form-control" placeholder="—" v-model="contact.zipcode">
                            </div>

                            <ActionButtons :urlIndex="urlIndex" />
                        </form>

                        <!-- ====================== STEP 4 - LOGO ====================== -->
                        <form v-if="step === 3" @submit.prevent="saveLogo">

                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" placeholder="—" v-model="logo.name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" @change="handleImage($event, 'logo')">
                            </div>

                            <ActionButtons :urlIndex="urlIndex" />
                        </form>

                        <!-- ====================== STEP 5 - TEXTO PRINCIPAL ====================== -->
                        <form v-if="step === 4" @submit.prevent="saveMainText">

                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" placeholder="—" v-model="mainText.title">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Texto</label>
                                <input type="text" class="form-control" placeholder="—" v-model="mainText.text">
                            </div>

                            <ActionButtons :urlIndex="urlIndex" />
                        </form>

                        <!-- ====================== STEP 6 - REDES SOCIAIS ====================== -->
                        <form v-if="step === 5" @submit.prevent="addSocial">

                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" placeholder="—" v-model="socialTemp.name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" placeholder="—" v-model="socialTemp.url">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ícone</label>
                                <input type="text" class="form-control" placeholder="Ex: bi bi-facebook"
                                    v-model="socialTemp.icon">
                            </div>

                            <div class="mb-3 text-center">
                                <button class="btn btn-success btn-sm" type="submit">Adicionar</button>
                            </div>

                            <ul class="list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    v-for="item in social" :key="item.tempId">
                                    <span><i :class="item.icon"></i> {{ item.name }} → {{ item.url }}</span>
                                    <button class="btn btn-danger btn-sm"
                                        @click="removeSocial(item.tempId)">Remover</button>
                                </li>
                            </ul>

                            <ActionButtons :urlIndex="urlIndex" saveDisabled />
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
            step: 0,
            steps: [
                "1",
                "2",
                "3",
                "4",
                "5",
                "6"
            ],
            about: {
                title: "",
                description: "",
                image: null
            },
            carrouselTemp: null,
            carrousel: [],
            contact: {
                phone: "",
                email: "",
                city: "",
                state: "",
                address: "",
                zipcode: ""
            },
            logo: {
                name: "",
                image: null
            },
            mainText: {
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

    methods: {
        handleImage(e, target) {
            const file = e.target.files[0];
            const preview = URL.createObjectURL(file);

            if (target === "carrouselTemp") {
                this.carrouselTemp = { tempId: Date.now(), file, preview };
            }
            else if (target === "about") this.about.image = file;
            else if (target === "logo") this.logo.image = file;
        },
        addCarrousel() {
            if (!this.carrouselTemp) return;
            this.carrousel.push(this.carrouselTemp);
            this.carrouselTemp = null;
        },
        removeCarrousel(id) {
            this.carrousel = this.carrousel.filter(i => i.tempId !== id);
        },
        addSocial() {
            this.social.push({ tempId: Date.now(), ...this.socialTemp });
            this.socialTemp = { name: "", url: "", icon: "" };
        },
        removeSocial(id) {
            this.social = this.social.filter(s => s.tempId !== id);
        },
        saveAbout() {
            alert("Salvar About (placeholder)");
        },
        saveContact() {
            alert("Salvar Contact (placeholder)");
        },
        saveLogo() {
            alert("Salvar Logo (placeholder)");
        },
        saveMainText() {
            alert("Salvar Main Text (placeholder)");
        }
    },

    components: {
        ActionButtons: {
            props: { urlIndex: String, saveDisabled: Boolean },
            template: `
                <div class="d-flex justify-content-between mt-4">
                    <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                    <button type="submit" class="btn btn-primary btn-sm" :disabled="saveDisabled">Salvar</button>
                </div>
            `
        }
    }
};
</script>
