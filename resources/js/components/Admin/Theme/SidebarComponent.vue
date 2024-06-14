<template>
    <div :class="['sidebar', { 'sidebar-collapsed': isCollapsed }]">
        <div class="sidebar-logo">
            <img src="../../../../../storage/app/public/images/logo/Logo_RGB_White+Green.png" alt="Logo">
        </div>
        <ul>
            <li v-for="menu in menus" :key="menu.id">
                <template v-if="menu.children && menu.children.length > 0">
                    <!-- Menu with children -->
                    <div @click="toggleSubmenu(menu)">
                        <a href="#" class="dropdown">
                            <i :class="menu.icon"></i>
                            <span class="menu-text">{{ menu.label }}</span>
                            <i class="fa fa-chevron-down" :class="{ 'open': menu.expanded }"></i>
                        </a>
                        <ul v-show="menu.expanded">
                            <li v-for="child in menu.children" :key="child.id">
                                <a :href="child.url">{{ child.label }}</a>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <!-- Menu without children -->
                    <router-link :to="menu.url">
                        <i :class="menu.icon"></i>
                        <span class="menu-text">{{ menu.label }}</span>
                    </router-link>
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
        }
    },
    data() {
        return {
            isCollapsed: this.initialCollapsed,
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
    background-color: #333;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    overflow-y: auto;
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
    margin: 0;
}

.sidebar ul li {
    margin: 10px 0;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar ul li a {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.sidebar ul li a .menu-text {
    display: inline-block;
}

.sidebar ul li a:hover {
    text-decoration: underline;
}

.dropdown {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}

.dropdown i.fa-chevron-down {
    margin-left: auto;
    transition: transform 0.3s ease;
}

.dropdown.open i.fa-chevron-down {
    transform: rotate(180deg);
}

ul {
    padding-left: 0;
}

ul ul {
    padding-left: 20px;
}
</style>