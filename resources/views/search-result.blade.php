@extends('layouts.app')

@section('title','Search')

@section('vue-components')
<v-app>
<navbar :show-search-field="false"></navbar>
<search-result q="{{$searchQuery}}"></search-result>
</v-app>
@endSection()