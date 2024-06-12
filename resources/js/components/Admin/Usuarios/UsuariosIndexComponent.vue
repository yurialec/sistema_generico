<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-3 text-left">
                    <h3>Usuários</h3>
                </div>
                <div class="col-sm-6 text-center">
                    <div class="input-group">
                        <input type="text" class="form-control" />
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-3 text-end">
                    <button type="button" class="btn btn-primary btn-sm">Cadastrar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="usuario in usuarios">
                        <th scope="row">{{ usuario.id }}</th>
                        <td>{{ usuario.name }}</td>
                        <td>{{ usuario.email }}</td>
                        <td>{{ usuario.role_id }}</td>
                        <td>
                            <i class="fa-regular fa-pen-to-square fa-lg"></i>&nbsp;&nbsp;&nbsp;
                            <i class="fa-regular fa-trash-can fa-lg"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            usuarios: [],
        };
    },
    mounted() {
        this.getUsuarios();
    },
    methods: {
        getUsuarios() {
            axios.get('http://localhost:8000/admin/usuarios/list')
                .then(response => {
                    this.usuarios = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    }
}
</script>
