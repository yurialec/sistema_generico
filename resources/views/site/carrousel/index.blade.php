@extends('layouts.app_admin')
@section('content')
<site-carrousel-index-component
    url-create-carrousel="{{ route('site.carrousel.create') }}">
</site-carrousel-index-component>
@endsection