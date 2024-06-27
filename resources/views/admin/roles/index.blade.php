@extends('layouts.app_admin')
@section('content')
    <roles-index-component
        url-create-role="{{ route('roles.create') }}">
    </roles-index-component>
@endsection
