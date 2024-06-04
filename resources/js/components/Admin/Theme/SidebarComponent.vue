<template>
    <div :class="['sidebar', { 'sidebar-collapsed': collapsed }]">
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a :href="urlUsers">Usuários</a></li>
            <li><a href="#">Perfis</a></li>
            <li><a href="#">Permissões</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Sidebar',
    props: {
        urlUsers: String,
        collapsed: {
            type: Boolean,
            default: false
        }
    }
}
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
    padding: 20px 0;
    transition: width 0.3s;
}

.sidebar-collapsed {
    width: 60px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 10px 0;
    padding-left: 20px;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
}

.sidebar ul li a:hover {
    text-decoration: underline;
}
</style>