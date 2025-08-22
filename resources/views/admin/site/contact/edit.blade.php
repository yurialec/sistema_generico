@extends('admin.layouts.app_admin')
@section('content')
<site-contact-edit-component
    id="{{ $id }}"
    url-index-contact="{{ route('site.contact.index') }}">
</site-contact-edit-component>
@endsection