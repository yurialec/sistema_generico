<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-3 text-left">
                    <h3>Perfis</h3>
                </div>
                <div class="col-sm-6 text-center">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="searchFilter" />
                        <button type="button" class="btn btn-primary" @click="pesquisar()">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-3 text-end">
                    <a :href="urlCreateRole" type="button" class="btn btn-primary btn-sm">Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles.data" :key="role.id">
                        <th scope="row">{{ role.id }}</th>
                        <td>{{ role.name }}</td>
                        <td>
                            <a :href="'perfis/editar/' + role.id">
                                <i class="fa-regular fa-pen-to-square fa-lg"></i>
                            </a>&nbsp;&nbsp;&nbsp;

                            <button type="button" style="color: red;" class="btn" @click="confirmarExclusao(role.id)"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-regular fa-trash-can fa-lg"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li v-for="(link, key) in roles.links" :key="key" class="page-item"
                        :class="{ 'active': link.active }">
                        <a class="page-link" href="#" @click.prevent="paginacao(link.url)" v-html="link.label"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar este registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" @click="excluirRegistro">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    props: {
        urlCreateRole: String,
    },
    data() {
        return {
            roles: {
                data: [],
                links: []
            },
            searchFilter: '',
            roleToDelete: null,
            alertStatus: null,
            msg: [],
        };
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        confirmarExclusao(roleId) {
            this.roleToDelete = roleId;
        },
        excluirRegistro() {
            if (this.roleToDelete !== null) {
                axios.delete(`http://localhost:8000/admin/perfis/delete/${this.roleToDelete}`)
                    .then(response => {
                        this.getRoles();
                        this.roleToDelete = null;
                        // Fecha a modal
                        const modal = Modal.getInstance(document.getElementById('exampleModal'));
                        if (modal) {
                            modal.hide();
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            }
        },
        pesquisar() {
            this.getRoles(`http://localhost:8000/admin/perfis/list?search=${this.searchFilter}`);
        },
        paginacao(url) {
            if (url) {
                this.getRoles(url);
            }
        },
        getRoles(url = 'http://localhost:8000/admin/perfis/list') {
            axios.get(url)
                .then(response => {
                    this.roles = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    }
}
</script>