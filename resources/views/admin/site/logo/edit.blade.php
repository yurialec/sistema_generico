@extends('admin.layouts.app_admin')
@section('content')
<site-logo-edit-component
    id="{{ $id }}"
    url-index-logo="{{ route('site.logo.index') }}">
</site-logo-edit-component>
@endsection