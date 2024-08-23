@extends('layouts.app_admin')
@section('content')
<site-contact-component
    url-create-contact="{{ route('site.contact.create') }}">
</site-contact-component>
@endsection