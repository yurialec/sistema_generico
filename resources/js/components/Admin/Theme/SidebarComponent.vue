<template>
    <div class="sidebar">
        <div class="sidebar-logo">
            <a :href="urlHome">
                <img src="../../../../../storage/app/public/images/logo/Logo_RGB_White+Green.png" alt="Logo">
            </a>
        </div>
        <ul>
            <li v-for="menu in menus" :key="menu.id">
                <template v-if="menu.children && menu.children.length > 0">
                    <!-- Menu with children -->
                    <div>
                        <a href="#" class="dropdown" @click.prevent="toggleSubmenu(menu)">
                            <i :class="menu.icon"></i>
                            <span class="menu-text">{{ menu.label }}</span>
                            <i class="fa fa-chevron-down" :class="{ 'open': menu.expanded }"></i>
                        </a>
                        <ul v-show="menu.expanded">
                            <li v-for="child in menu.children" :key="child.id">
                                <a :href="child.url">
                                    <i :class="child.icon"></i>
                                    <span class="menu-text">{{ child.label }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <!-- Menu without children -->
                    <a :href="menu.url">
                        <i :class="menu.icon"></i>
                        <span class="menu-text">{{ menu.label }}</span>
                    </a>
                </template>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Sidebar',
    props: {
        menus: {
            type: Array,
            required: true
        },
        urlHome: String,
    },
    data() {
        return {
            menus: [],
            submenuState: {},
        };
    },
    created() {
        this.getMenus();
    },
    methods: {
        getMenus() {
            axios.get('http://localhost:8000/admin/menus')
                .then(response => {
                    this.menus = response.data.map(menu => {
                        return { ...menu, expanded: false }; // Adiciona a propriedade 'expanded' usando spread operator
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        },
        toggleSubmenu(menu) {
            menu.expanded = !menu.expanded;
        },
        closeAllSubmenus(currentMenu) {
            this.menus.forEach(menu => {
                if (menu !== currentMenu && menu.expanded) {
                    menu.expanded = false;
                }
            });
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
    overflow: hidden;
}

.sidebar-logo {
    padding: 20px;
    text-align: center;
}

.sidebar-logo img {
    max-width: 100%;
    height: auto;
    transition: width 0.3s;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    display: flex;
    align-items: center;
    margin: 10px 0;
    padding: 10px 20px;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    width: 100%;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.sidebar ul li a .menu-text {
    display: inline-block;
}
</style>