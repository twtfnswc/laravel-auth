@extends('layout.main')
@section('content')
	{{Form::open(array('action'=>'AccountController@postCreate'))}}
		
		
		<p> 
			{{Form::label('email','Email')}}
			{{Form::text('email',Input::old('email'))}}
			@if($errors->has('email'))
				{{$errors->first('email')}}
			@endif
		</p>
		<p> 
			{{Form::label('username','Username:')}}
			{{Form::text('username')}}
			@if($errors->has('username'))
				{{$errors->first('username')}}
			@endif
		</p> 
		<p>
			{{Form::label('password','Password:')}}
			{{Form::password('password')}}
			@if($errors->has('password'))
				{{$errors->first('password')}}
			@endif
		</p>	
		
		<p> 
			{{Form::label('password_again','Password again:')}}
			{{Form::password('password_again')}}
			@if($errors->has('password_again'))
				{{$errors->first('password_again')}}
			@endif
		</p>

		{{Form::submit('create account')}}
	{{Form::close()}}
@stop