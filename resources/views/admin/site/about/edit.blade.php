@extends('admin.layouts.app_admin')
@section('content')
    <site-about-edit-component
        id="{{ $id }}"
        url-index-about="{{ route('site.about.index') }}">
    </site-about-edit-component>
@endsection