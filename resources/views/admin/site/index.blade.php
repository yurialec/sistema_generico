@extends('admin.layouts.app_admin')
@section('content')
    <site-index-component
        url-create="{{ route('site.create') }}"
        url-edit="{{ route('site.edit', ['id' => '_id']) }}">
    </site-index-component>
@endsection