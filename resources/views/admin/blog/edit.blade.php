@extends('admin.layouts.app_admin')
@section('content')
<blog-edit-component
    id="{{ $id }}"
    url-index-blog="{{ route('blog.index') }}">
</blog-edit-component>
@endsection