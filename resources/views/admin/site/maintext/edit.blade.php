@extends('admin.layouts.app_admin')
@section('content')
    <site-main-text-edit-component
        id="{{ $id }}" url-index-main-text="{{ route('site.maintext.index') }}">
    </site-main-text-edit-component>
@endsection