<sidebar-component
    :menus="{{ \App\Models\Admin\Menu::menus() }}"
    url-sair="{{ route('logout') }}">
</sidebar-component>
