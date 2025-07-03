@extends('admin.layouts.app_admin')
@section('content')
    <roles-edit-component
        id="{{ $id }}"
        url-index-role="{{ route('roles.index') }}">
    </roles-edit-component>
@endsection
