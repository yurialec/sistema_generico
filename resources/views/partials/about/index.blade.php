@extends('layouts.app')
@include('partials.navbar')
<div class="main-content container">
    <div class="container">
        <div class="row">
            @if($about->image)
            <div class="col-sm-4 text-end">
                <img src="{{'/storage/' .$about->image}}" width="400">
            </div>
            @else

            @endif
            <div class="col-sm-4">
                @if($about->title)
                <h1>{{$about->title}}</h1>
                @else
                @endif
                @if($about->description)
                <h3>{{$about->description}}</h3>
                @else
                @endif
            </div>
        </div>
    </div>
</div>
@include('partials.footer')