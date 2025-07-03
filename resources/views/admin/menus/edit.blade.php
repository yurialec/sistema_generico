@extends('admin.layouts.app_admin')
@section('content')
    <menus-edit-component
        id="{{ $id }}"
        url-index-menu="{{ route('menu.index') }}">
    </menus-edit-component>
@endsection
