@extends('layouts.app')
@section('title','Login - Sign up')
@section('vue-components')
<navbar></navbar>
<login>
<div slot="login-status">
@if(session("login-status"))
<div class="text-red-600">
    {{session("login-status")}}
</div>
@endif
</div>
@if($errors)
    @foreach($errors->all() as $error)
    <div class="text-red-600">
        {{$error}}
    </div>
    @endforeach
@endif
@if(session("message"))
<div class="text-blue-600">
    {{session("message")}}
</div>
@endif
</login>
@endSection()