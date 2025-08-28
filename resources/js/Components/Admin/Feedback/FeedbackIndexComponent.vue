<template>
    <div class="card">
        <div class="card-header py-2">
            <div class="row align-items-center g-2">
                <div class="col-md-3 col-12">
                    <h5 class="mb-0">Feedback</h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" v-model="searchFilter" placeholder="Buscar..." />
                        <button type="button" class="btn btn-sm btn-primary">
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
                            <th>Coluna A</th>
                            <th>Coluna B</th>
                            <th>Coluna C</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder de linha (sem dados ainda) -->
                        <tr>
                            <td>1</td>
                            <td>—</td>
                            <td>—</td>
                            <td>—</td>
                            <td>
                                <a :href="urlEdit.replace('_id', 1)" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Sem dados (placeholder)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer py-2">
            <nav>
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    <li class="page-item disabled"><span class="page-link">Anterior</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item disabled"><span class="page-link">Próximo</span></li>
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
    },
    data() {
        return {
            searchFilter: ''
        }
    }
}
</script>