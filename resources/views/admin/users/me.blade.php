@extends('layouts.app_admin')
@section('content')
    <users-me-component user="{{ json_encode($user) }}"></users-me-component>
@endsection
