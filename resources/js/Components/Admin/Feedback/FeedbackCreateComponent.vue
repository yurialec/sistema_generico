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
                                <label class="form-label">Campo A</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo B</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Campo C</label>
                                <input type="text" class="form-control" placeholder="—">
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a :href="urlIndex" class="btn btn-outline-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-primary btn-sm" disabled>Salvar</button>
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
    methods: {
        save() {
            // Placeholder: sem integração ainda
        }
    }
}
</script>