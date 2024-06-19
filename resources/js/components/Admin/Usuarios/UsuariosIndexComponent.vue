<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-3 text-left">
                    <h3>Usuários</h3>
                </div>
                <div class="col-sm-6 text-center">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="filtroPesquisa" />
                        <button type="button" class="btn btn-primary" @click="pesquisar()">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-3 text-end">
                    <a :href="urlCadastrarUsuario" type="button" class="btn btn-primary btn-sm">Cadastrar</a>
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
                    <tr v-for="usuario in usuarios.data" :key="usuario.id">
                        <th scope="row">{{ usuario.id }}</th>
                        <td>{{ usuario.name }}</td>
                        <td>{{ usuario.email }}</td>
                        <td>{{ usuario.role.name }}</td>
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
                    <li v-for="(link, key) in usuarios.links" :key="key" class="page-item"
                        :class="{ 'active': link.active }">
                        <a class="page-link" href="#" @click.prevent="paginacao(link.url)" v-html="link.label"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        urlCadastrarUsuario: String,
    },
    data() {
        return {
            usuarios: {
                data: [],
                links: []
            },
            filtroPesquisa: '',
        };
    },
    mounted() {
        this.getUsuarios();
    },
    methods: {
        pesquisar() {
            this.getUsuarios('http://localhost:8000/admin/usuarios/list', this.filtroPesquisa);
        },
        paginacao(url) {
            if (url) {
                this.getUsuarios(url);
            }
        },
        getUsuarios(url = 'http://localhost:8000/admin/usuarios/list') {
            axios.get(url)
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