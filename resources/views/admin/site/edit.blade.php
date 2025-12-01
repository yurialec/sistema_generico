@extends('admin.layouts.app_admin')
@section('content')
    <site-edit-component
        :id="'{{ $id }}'"
        url-index="{{ route('site.index') }}">
    </site-edit-component>
@endsection