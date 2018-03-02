@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Findings for  - <strong>'.$building->name.'</strong>')
@section('page_description','Manage findings here.')



@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

<div class="callout callout-info">
    <h4>EOP : {{$eop->name}}</h4>
    <p>{{$eop->text}}</p>
</div>

@endsection