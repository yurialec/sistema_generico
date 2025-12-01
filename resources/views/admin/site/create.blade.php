@extends('admin.layouts.app_admin')
@section('content')
    <site-create-component
        url-index="{{ route('site.index') }}">
    </site-create-component>
@endsection