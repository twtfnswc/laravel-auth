@extends('layout.main')
@section('content')
	{{Form::open(array('Route'=>'account-sign-in-post'))}}
		<p> 
			{{Form::label('email','Email')}}
			{{Form::text('email',Input::old('email'))}}
			@if($errors->has('email'))
				{{$errors->first('email')}}
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
			{{Form::checkbox('remenber')}}
			{{Form::label('remenber','Remenber me')}}
		</p>	
		<P>
			{{Form::token()}}

			{{Form::submit('login')}}
		</P>

	{{Form::close()}}
@stop