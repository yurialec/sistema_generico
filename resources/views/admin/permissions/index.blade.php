@extends('admin.layouts.app_admin')
@section('content')
    <permissions-index-component
        url-edit-permission="{{ route('permissions.edit', ['id' =>'_id']) }}"
        url-create-permission="{{ route('permissions.create') }}">
    </permissions-index-component>
@endsection