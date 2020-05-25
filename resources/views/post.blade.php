@extends('layouts.app')

@section('title','Seer system -'.$post->title)

@section('vue-components')
<v-app>
<navbar ></navbar>
<post-page :post="{{json_encode($post)}}"  author-name="{{$post->user()->first()->name}}"></post-page>
</v-app>
@endSection()