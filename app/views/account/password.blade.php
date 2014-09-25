@extends('layout.main')

@section('content')
	{{Form::open(array('route'=>'account-change-password'))}}
		<p>
			{{Form::label('password','Old Password:')}}
			{{Form::password('oldPassword')}}
			@if($errors->has('oldPassword'))
				{{$errors->first('oldPassword');}}
			@endif
		</p>
		<p>
			{{Form::label('password','New Password:')}}
			{{Form::password('newPassword')}}
			@if($errors->has('newPassword'))
				{{$errors->first('newPassword');}}
			@endif
		</p>
		<p>
			{{Form::label('password','New Password again:')}}
			{{Form::password('newPassword2')}}
			@if($errors->has('newPassword2'))
				{{$errors->first('newPassword2');}}
			@endif 
		</p>
		{{Form::submit('change')}}

	{{Form::close()}}
@stop