<template>
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav mt-3">
                <template v-for="(menu, index) in sidebar" :key="menu.id">
                    <div v-if="menu.children && menu.children.length">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            :data-bs-target="'#collapseMenu' + menu.id" aria-expanded="false"
                            :aria-controls="'collapseMenu' + menu.id">
                            <div class="sb-nav-link-icon">
                                <i :class="menu.icon"></i>
                            </div>
                            {{ menu.label }}
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" :id="'collapseMenu' + menu.id" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a v-for="child in menu.children" :key="child.id" class="nav-link" :href="child.url">
                                    <i :class="child.icon" class="me-2"></i>
                                    {{ child.label }}
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div v-else>
                        <a class="nav-link" :href="menu.url">
                            <div class="sb-nav-link-icon">
                                <i :class="menu.icon"></i>
                            </div>
                            {{ menu.label }}
                        </a>
                    </div>
                </template>

            </div>
        </div>
    </nav>
</template>

<script>

export default {
    name: 'Sidebar',
    props: {
    },
    data() {
        return {
            loading: false,
            sidebar: [],
        };
    },
    mounted() {
        this.getSidebarMenu();
    },
    created() {

    },
    methods: {
        getSidebarMenu() {
            this.loading = true;
            axios.get('admin/sidebar')
                .then(response => {
                    this.sidebar = response.data.sidebar;
                })
                .catch(errors => {
                    this.alertDanger(errors);
                }).finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>
