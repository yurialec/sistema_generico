@extends('admin.layouts.app_admin')
@section('content')
    <feedback-index-component
        url-create="{{ route('feedback.create') }}"
        url-edit="{{ route('feedback.edit', ['id' => '_id']) }}">
    </feedback-index-component>
@endsection