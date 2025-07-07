@extends('admin.layouts.app_admin')
@section('content')
<site-logo-index-component
    url-create-logo="{{ route('site.logo.create') }}"
    url-edit-logo="{{ route('site.logo.edit', ['id' => '_id']) }}">
</site-logo-index-component>
@endsection