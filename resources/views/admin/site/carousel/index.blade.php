@extends('admin.layouts.app_admin')
@section('content')
    <site-carrousel-index-component
        url-create-carousel="{{ route('site.carousel.create') }}"
        url-edit-carousel="{{ route('site.carousel.edit', '_id') }}">
    </site-carrousel-index-component>
@endsection