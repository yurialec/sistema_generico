<template>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="bars">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <div class="navbar-content">
            <div class="avatar" @click="toggleDropdown">
                <i class="fa-regular fa-user"></i>
                <div class="dropdown-menu setting" :class="{ active: showDropdown }">
                    <div class="item">
                        <span class="fa-solid fa-user"></span> <a style="text-decoration: none;" :href="urlProfile">Meu
                            Cadastro</a>
                    </div>
                    <div class="item">
                        <span class="fa-solid fa-arrow-right-from-bracket"></span><a style="text-decoration: none;"
                            :href="urlSair">Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Header',
    props: {
        urlSair: String,
        urlProfile: String,
    },
    data() {
        return {
            showDropdown: false
        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        }
    }
};
</script>
