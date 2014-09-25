<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestController extends BaseController {
    public function getIndex()
    {
        /*$data = DB::select('select * from code');
        $name = '';
        foreach($data as $v)
        {
            $name .= $v->username.'['.$v->id.']<br>';
        }*/
        if(Auth::attempt(array('username' => 'guest', 'password' => '123456')))
        {
            return 'yes';
        }
        else return 'no';
    }
    public function getLog()
    {
        if (Auth::check())
        {
            return 'you have logged in';
        }
        else return 'you did not log in';
    }
    public function getMysitu()
    {
        return Auth::user()->password;
    }
    public function getLogout()
    {
        Auth::logout();
        return 'logout';
    }
    public function postIndex()
    {
        $input = Input::only('username', 'password');
        if($input['username']=='admin' && $input['password']) $message = 'Login success';
        else $message = 'Wrong';
        return $message;
    }
}