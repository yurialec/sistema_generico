<template>
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-light shadow">
        <a class="navbar-brand ps-3" :href="urlHome">
            <img v-if="logoRoute" :src="logoRoute" alt="Home" class="img-fluid" style="max-height: 40px;">
            <p v-if="!logoRoute">Home</p>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"
            @click="handleClick">
            <i class="bi bi-list h3"></i>
        </button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group"></div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" :href="urlProfile">Meu Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" :href="urlLogout">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        urlHome: String,
        urlProfile: String,
        urlLogout: String,
        logoRoute: String,
    },
    methods: {
        handleClick() {
            let body = document.body;

            if (body.classList.contains("sb-sidenav-toggled")) {
                body.classList.remove("sb-sidenav-toggled");
            } else {
                body.classList.add("sb-sidenav-toggled");
            }
        }
    }
};
</script>
