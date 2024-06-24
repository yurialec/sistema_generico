@extends('layouts.app_admin')
@section('content')
    <roles-edit-component role-by-id="{{ json_encode($role) }}"></roles-edit-component>
@endsection
