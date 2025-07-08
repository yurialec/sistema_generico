@extends('admin.layouts.app_admin')
@section('content')
<site-main-text-index-component
    url-create-main-text="{{ route('site.maintext.create') }}"
    url-edit-main="{{ route('site.maintext.edit', ['id' => '_id']) }}">
</site-main-text-index-component>
@endsection