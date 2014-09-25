<?php

class AccountController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function getRecover($code)
	{
		$user =User::where('code','=',$code)
				->where('passtemp','!=','');
		if($user->count()){
			$user =$user->first();
			$user->password=$user->passtemp;
			$user->passtemp='';
			$user->code    ='';
			if($user->save())
			{
				return Redirect::route('home')
						-> with('global','recovered your account');
			}
		}

		return Redirect::route('home')
				->with('global','Could not recover your account');

	}

	public function getForgotPassword()
	{
		return View::make('account.forgot');
	}

	public function postForgotPassword()
	{
		$validator=Validator::make(Input::all(),array(
			'email' =>'required|email'
			));
		if($validator->fails())
		{
			return Redirect::route('account-forgot-password')
				->withErrors($validator)
				->withInput();
		}
		else{
			$user =User::where('email','=',Input::get('email'));
		
			if($user->count())
			{
			$user 			=$user->first();
				$code		=str_random(60);
			$password   	=str_random(10);
			$user->code 	=$code;
			$user->passtemp =Hash::make($password);
				if($user->save())
				{
					Mail::send('emails.auth.forgot',array(
						'link'=>URL::route('account-recover',$code),'username'=>$user->username,'password'=>$password),
						function($message) use ($user){
							$message->to($user->email,$user->username)->subject('your new password');
						});
					return Redirect::route('home')
							->with('global','we have sent you your new password');
				}
			}
		}
		return  Redirect::route('account-forgot-password')
				->with('global','could not request new password');

	}

	public function getSignIn()
	{
		return View::make('account.signin');
	}


	public function postSignIn()
	{
		$validator=Validator::make(Input::all(),
				array(
					'email'		=>'required|email',
					'password'	=>'required'
					)
			);
		if($validator->fails())
		{
			return Redirect::route('account-sign-in')
				->withErrors($validator)
				->withInput();
		}
		else
		{
			$remenber=Input::has('remenber');
			$auth=Auth::attempt(array(
				'email'		=>Input::get('email'),
				'password'	=>Input::get('password'),
				'active'	=>1
			),$remenber);

			if($auth)
			{
				return Redirect::intended('/');
			}
		}

		return Redirect::route('account-sign-in')
		->with('global','there were problems signing in');
	}

	public function getSignOut(){
		Auth::logout();
		return Redirect::route('home');
	}



	public function getCreate(){
		return View::make('account.create');
	}

	public function postCreate(){
		//$input =Input::all();
		$validator=Validator::make(Input::all(),array(
			'email' 		=>'required|max:50|email|unique:users',
			'username'		=>'required|max:20|min:3|unique:users',
			'password'		=>'required|min:6',
			'password_again'=>'required|same:password'
			));
		if($validator->fails())
		{
			return Redirect::route('account-create')
				->withErrors($validator)
				->withInput();
		}
		else{
			$email		=Input::get('email');
			$username	=Input::get('username');
			$password 	=Input::get('password');

			$code		=str_random(60);
			//dd($username);exit;
			$create 	=User::create(array(
					'email'		=>$email,
					'username'	=>$username,
					'password'	=>Hash::make($password),
					'code' 		=>$code,
					'active'	=>0,
				));

			if($create)
			{
				//send email
				Mail::send('emails.auth.activate',array(
						'link'	  =>URL::route('account-activate',$code),
						'username'=>$username),
						function($message) use ($create) {
						$message
						->to($create->email,$create->username)
						->subject('activate your account');

				});

				return Redirect::route('home')
						->with('global','success! created.');

			}
		}
		
		return Redirect::to('/')->with('message','Thanks for register');
	}


	public function getActivate($code)
	{	
		$user =User::where('code','=',$code)->where('active','=',0);

		if($user->count())
		{
			$user=$user->first();

			//update
			$user->active 	=1;
			$user->code  	='';
		
			if($user->save())
			{
				return Redirect::route('home')
				->with('global','activated!!!!!!');

			}
		}
		return Redirect::route('home')
			->with('global','we could not actiavte your account');


	}

	public function getChangePassword(){
		return View::make('account.password');
	}

	public function postChangePassword(){
		$validator= Validator::make(Input::all(),array(
			'oldPassword' 		=>'required',
			'newPassword'		=>'required|min:6',
			'newPassword2'		=>'required|same:newPassword'
		));

		if($validator->fails())
		{
			return Redirect::route('account-change-password')
					->withErrors($validator)
					->withInput();
		}else{
			$user =User::find(Auth::user()->id);

			$oldPassword =Input::get('oldPassword');
			$password =Input::get('newPassword');

			if(Hash::Check($oldPassword,$user->getAuthPassword()))
			{
				$user->password =Hash::make($password);

				if($user->save())
				{
					return Redirect::route('home')
							->with('global','your password has been changed,
								please re-sign in.');
				}else{
					return Redirect::route('account-change-password')
				->withErrors($validator)
				->with('global','incorrect password');
				
				}
			}

		}
		return Redirect::route('account-change-password')
				->withErrors($validator)
				->with('global','you could not change the password');
	}
}
