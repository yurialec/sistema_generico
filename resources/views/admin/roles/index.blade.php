@extends('layouts.app_admin')
@section('content')
    <roles-index-component
        url-create-role="{{ route('roles.cadastrar') }}">
    </roles-index-component>
@endsection
