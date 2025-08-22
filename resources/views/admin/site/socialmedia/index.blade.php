@extends('admin.layouts.app_admin')
@section('content')
<site-social-media-index-component
    url-create-social-media="{{ route('site.socialmedia.create') }}"
    url-edit-social-media="{{ route('site.socialmedia.edit', '_id') }}">
</site-social-media-index-component>
@endsection