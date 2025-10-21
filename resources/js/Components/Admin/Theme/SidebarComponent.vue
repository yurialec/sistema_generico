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
        <!-- <div class="sb-sidenav-footer text-center p-3 border-top">
            <button v-if="userRole"
                class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2"
                @click="downloadBackup()">
                <i class="bi bi-database-down fs-4"></i>
                <span>Backup SQL</span>
            </button>
        </div> -->
    </nav>
</template>

<script>

export default {
    name: 'Sidebar',
    props: {
        userRole: String,
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
        },
        downloadBackup() {
            this.loading = true;
            axios.post('admin/download-backup', {}, {
                responseType: 'blob'
            })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;

                    const contentDisposition = response.headers['content-disposition'];
                    let fileName = 'backup.sql';
                    if (contentDisposition) {
                        const fileNameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
                        if (fileNameMatch.length > 1) {
                            fileName = fileNameMatch[1];
                        }
                    }

                    link.setAttribute('download', fileName);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                    window.URL.revokeObjectURL(url);
                })
                .catch(errors => {
                    this.alertDanger(errors);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>
