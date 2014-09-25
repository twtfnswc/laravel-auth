@extends('layout.main')

@section('content')
	@if(Auth::check())
		<p>hello,{{Auth::user()->username}}</p>
	@else
		<p>You are not signed in.</p>
	@endif
@stop