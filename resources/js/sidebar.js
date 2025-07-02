window.addEventListener('load', () => {
    setTimeout(() => {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                document.body.classList.toggle('sb-sidenav-toggled');
                localStorage.setItem(
                    'sb|sidebar-toggle',
                    document.body.classList.contains('sb-sidenav-toggled')
                );
            });
        }
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.add('sb-sidenav-toggled');
        }
    }, 0);
});