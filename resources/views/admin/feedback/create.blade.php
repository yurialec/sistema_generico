@extends('admin.layouts.app_admin')
@section('content')
    <feedback-create-component
        url-index="{{ route('feedback.index') }}">
    </feedback-create-component>
@endsection