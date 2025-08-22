@extends('admin.layouts.app_admin')
@section('content')
<site-carousel-edit-component
    id="{{ $id }}"
    url-index-carousel="{{ route('site.carousel.index') }}">
</site-carousel-edit-component>
@endsection