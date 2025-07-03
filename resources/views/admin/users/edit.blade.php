@extends('admin.layouts.app_admin')
@section('content')
    <users-edit-component
        id="{{ $id }}"
        url-index-user="{{ route('users.index') }}">
    </users-edit-component>
@endsection
