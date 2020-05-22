@extends('layouts.app')

@section('title','Edit Post')

@section('vue-components')
<v-app>
<navbar ></navbar>
<post-edit :post="{{json_encode($post)}}"></post-edit>
</v-app>
@endSection()