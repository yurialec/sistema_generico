@extends('layouts.app_admin')
@section('content')
    <usuarios-create-component csrf_token='{{ @csrf_token() }}'></usuarios-create-component>
@endsection
