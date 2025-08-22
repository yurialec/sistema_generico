@extends('admin.layouts.app_admin')
@section('content')
<site-social-media-create-component
    url-index-social-media="{{ route('site.socialmedia.index') }}">
</site-social-media-create-component>
@endsection