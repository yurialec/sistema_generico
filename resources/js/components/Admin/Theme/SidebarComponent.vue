<template>
        <div class="sidebar">
            <ul class="sidebar-list">
                <li class="sidebar-list-items" v-for="menu in menus" :key="menu.id">
                    <template v-if="menu.children && menu.children.length > 0">
                        <!-- Menu with children -->
                        <div>
                            <a href="#" class="sidebar-nav" @click.prevent="toggleSubmenu(menu)">
                                <i :class="menu.icon"></i>
                                <span>{{ menu.label }}</span>
                                <i class="fa fa-chevron-down" :class="{ 'open': menu.expanded }"></i>
                            </a>
                            <ul v-show="menu.expanded">
                                <li v-for="child in menu.children" :key="child.id">
                                    <a :href="child.url">
                                        <i :class="child.icon"></i>
                                        <span>{{ child.label }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </template>
                    <template v-else>
                        <!-- Menu without children -->
                        <a :href="menu.url">
                            <i :class="menu.icon"></i>
                            <span>{{ menu.label }}</span>
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
            axios.get('/admin/menus')
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
