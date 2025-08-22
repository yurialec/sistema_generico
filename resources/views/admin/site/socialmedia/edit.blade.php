@extends('admin.layouts.app_admin')
@section('content')
<site-social-media-edit-component
    id="{{ $id }}"
    url-index-social-media="{{ route('site.socialmedia.index') }}">
</site-social-media-edit-component>
@endsection