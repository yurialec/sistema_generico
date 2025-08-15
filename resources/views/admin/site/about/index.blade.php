@extends('admin.layouts.app_admin')
@section('content')
    <site-about-index-component
        url-create-about="{{ route('site.about.create') }}"
        url-edit-about="{{ route('site.about.edit', ['id' => '_id']) }}">
    </site-about-index-component>
@endsection