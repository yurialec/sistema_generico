@extends('admin.layouts.app_admin')
@section('content')
    <site-edit-component
        url-index="{{ route('site.index') }}">
    </site-edit-component>
@endsection