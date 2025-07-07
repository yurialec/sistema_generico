@php
    $logo = App\Models\Site\SiteLogo::first();
@endphp
<header-component
    url-profile="{{ route('profile.view') }}"
    url-home="{{ route('home') }}"
    url-logout="{{ route('logout') }}"
    logo-route="{{ $logo && $logo->image ? asset('storage/' . $logo->image) : '' }}">
</header-component>