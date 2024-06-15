<template>
    <div :class="['sidebar', { 'sidebar-collapsed': isCollapsed }]">
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
                            <span class="menu-text" v-if="!isCollapsed">{{ menu.label }}</span>
                            <i class="fa fa-chevron-down" :class="{ 'open': menu.expanded }" v-if="!isCollapsed"></i>
                        </a>
                        <ul v-show="menu.expanded && !isCollapsed">
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
                        <span class="menu-text" v-if="!isCollapsed">{{ menu.label }}</span>
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
    transition: width 0.3s ease;
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
    padding: 0 10px;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.sidebar ul li a .menu-text {
    display: inline-block;
}

.sidebar ul li a:hover {
    background-color: #0d6efd;
    border-radius: 05px;
    display: flex;
    align-items: center;
    padding: 10 10px;
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

.dropdown i.open {
    margin-left: auto;
    transform: rotate(180deg);
}

ul {
    padding-left: 0;
}

ul ul {
    padding-left: 20px;
}

.collapse-btn {
    background: none;
    border: none;
    color: #fff;
    width: 100%;
    padding: 10px;
    text-align: center;
    cursor: pointer;
}

.collapse-btn i {
    font-size: 1.2em;
}
</style>