@extends('admin.layouts.app_admin')
@section('content')
<site-contact-index-component
    url-create-contact="{{ route('site.contact.create') }}"
    url-edit-contact="{{ route('site.contact.edit', '_id') }}"
    >
</site-contact-index-component>
@endsection