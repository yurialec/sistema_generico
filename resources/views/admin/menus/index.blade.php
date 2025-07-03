@extends('admin.layouts.app_admin')
@section('content')
    <menus-index-component
        url-create-menu="{{ route('menu.create') }}"
        url-edit-menu="{{ route('menu.edit', ['id' => '_id']) }}">
    </menus-index-component>
@endsection
