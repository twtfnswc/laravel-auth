@extends('layout.main')

@section('content')
	{{Form::open(array('route'=>'account-forgot-password'))}}
		<p>{{Form::text('email')}}</p>
		@if($errors->has('email'))
			{{$errors ->first()}}
		@endif
		<p>{{Form::submit('submit')}}</p> 
	{{Form::close()}}
@stop