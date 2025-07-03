@extends('admin.layouts.app_admin')
@section('content')
<blog-index-component
    url-create-blog="{{ route('blog.create') }}"
    url-edit-blog="{{ route('blog.edit', ['id'=> '_id']) }}">
</blog-index-component>
@endsection