<nav>
<ul>
	<li><a href="{{ URL::route('home')}}">Home</a></li>

	@if(Auth::check())
	<li><a href="{{ URL::route('account-sign-out')}}">sign out</a></li>
	<li><a href="{{ URL::route('account-change-password')}}">change password</a></li>
	@else
	<li><a href="{{ URL::route('account-sign-in')}}">sign in</a></li>
	<li><a href="{{ URL::route('account-create')}}">Create an account</a></li>
	<li><a href="{{ URL::route('account-forgot-password')}}">forget the password</a></li>
	@endif
</ul>
</nav>