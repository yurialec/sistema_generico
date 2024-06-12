<template>
    <div :class="['sidebar', { 'sidebar-collapsed': isCollapsed }]">
        <div class="sidebar-logo">
            <img src="#" alt="Logo">
        </div>
        <ul>
            <li v-for="menu in menus" :key="menu.id">
                <a :href="menu.url">
                    <i :class="menu.icon"></i>
                    <span class="menu-text">{{ menu.label }}</span>
                </a>
            </li>
            <li>
                <a :href="urlSair"><i class="fa-solid fa-right-from-bracket"></i></a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Sidebar',
    props: {
        initialCollapsed: {
            type: Boolean,
            default: false
        },
        menus: {
            type: Array,
            required: true
        },
        urlSair: String,
    },
    data() {
        return {
            isCollapsed: this.initialCollapsed
        };
    },
    methods: {
        toggleSidebar() {
            this.isCollapsed = !this.isCollapsed;
            this.$emit('update:collapsed', this.isCollapsed);
        }
    }
};
</script>

<style scoped>
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #333;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    transition: width 0.3s;
    z-index: 1000;
}

.sidebar-collapsed {
    width: 60px;
}

.sidebar-logo {
    padding: 20px;
    text-align: center;
}

.sidebar-logo img {
    max-width: 100%;
    height: auto;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 10px 0;
    padding-left: 20px;
    display: flex;
    align-items: center;
    font-size: larger;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.sidebar-collapsed .menu-text {
    display: none;
}

.sidebar ul li a:hover {
    text-decoration: underline;
}
</style>