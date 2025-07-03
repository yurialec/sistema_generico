@extends('admin.layouts.app_admin')
@section('content')
    <roles-index-component
        url-create-role="{{ route('roles.create') }}"
        url-edit-role="{{ route('roles.edit', ['id' =>'_id']) }}">
    </roles-index-component>
@endsection
