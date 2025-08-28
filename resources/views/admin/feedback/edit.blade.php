@extends('admin.layouts.app_admin')
@section('content')
    <feedback-edit-component
        :id="'{{ $id }}'"
        url-index="{{ route('feedback.index') }}">
    </feedback-edit-component>
@endsection