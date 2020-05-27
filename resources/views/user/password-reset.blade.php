@extends('layouts.app')
@section('vue-components')
<navbar></navbar>
<password-reset token='{{$token}}'>
@if($errors)
    @foreach($errors->all() as $error)
    <div class="text-red-600">
        {{$error}}
    </div>
    @endforeach
@endif

@if(session('status'))
<p>{{session('status')}}</p>
@endif
</password-reset>
@endSection()