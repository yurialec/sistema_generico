<template>
    <nav class="navbar">
        <div class="navbar-content">
            <button class="btn custom-btn" @click="handleClick">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="navbar-content">
            <div class="avatar" @click="toggleDropdown">
                {{ this.user.name }}&nbsp;&nbsp;&nbsp;<i class="fa-regular fa-user"></i>
                <div class="dropdown-menu setting" :class="{ active: showDropdown }">
                    <a class="item" :href="urlProfile">
                        <span class="fa-solid fa-user"></span> Meu Cadastro
                    </a>
                    <a class="item" :href="urlSair">
                        <span class="fa-solid fa-arrow-right-from-bracket"></span> Sair
                    </a>
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
            showDropdown: false,
            user: [],
        };
    },
    mounted() {
        this.getProfile();
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
        getProfile() {
            axios.get('admin/users/profile')
                .then(response => {
                    this.user = response.data.profile;
                })
                .catch(error => {
                });
        },
        handleClick() {
            let sidebar = document.querySelector(".sidebar");
            sidebar.classList.contains("active") ? sidebar.classList.remove("active") : sidebar.classList.add("active");
        }
    }
};
</script>
