<template>
    <header class="header">
        <button @click="toggleSidebar" class="collapse-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa-regular fa-user fa-lg"></i>
            </button>
            <div class="dropdown-content">
                <a href="@">Meu Cadastro</a>
                <a :href="urlSair">Sair</a>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'Header',
    props: {
        urlSair: String,
    },
    methods: {
        toggleSidebar() {
            this.$emit('toggle-sidebar');
        }
    }
};
</script>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #333;
    color: white;
    padding: 0 20px;
    height: 60px;
    position: fixed;
    top: 0;
    left: 250px;
    right: 0;
    z-index: 999;
    transition: left 0.3s;
}

.header-collapsed {
    left: 60px;
}

.collapse-btn {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>