@extends('layouts.app_admin')
@section('content')
    <usuarios-index-component url-cadastrar-usuario="{{ route('usuarios.cadastrar') }}">
    </usuarios-index-component>
@endsection
