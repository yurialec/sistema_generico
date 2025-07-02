@extends('admin.layouts.app_admin')
@section('content')
    <permissions-edit-component
        id="{{ $id }}"
        url-index-permissions="{{ route('permissions.index') }}">
    </permissions-edit-component>
@endsection
