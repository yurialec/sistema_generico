@extends('admin.layouts.app_admin')
@section('content')
    <users-index-component
        url-create-user="{{ route('users.create') }}"
        url-edit-user="{{route('users.edit', ['id' =>'_id'])}}">
    </users-index-component>
@endsection
