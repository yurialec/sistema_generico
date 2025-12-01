@extends('admin.layouts.app_admin')
@section('content')
    <site-index-component
        url-edit="{{ route('site.edit') }}">
    </site-index-component>
@endsection