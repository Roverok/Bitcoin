<?php
/*
 |============================================================================
 | Author      : Li, Yuan
 | File        : UserController.php
 | email       : yuan.li@student.emw.hs-anhalt.de
 | Version     : 1.0
 | Copyright   : All rights reserved by Anhalt University of Applied Sciences
 | Description : 
 |     UserController Class is used to handle administration login action. Use
 | PHP PAM module to check user credentials. When login successed, this user 
 | will log into the application.
 |
 |============================================================================
 */

 class UserController extends Controller
 {
	// handle login action
 	public function loginAction()
 	{
		// can only login by using ajax request
 		if (Request::ajax()) {
			// certificate variable for storing username and password from post request
 			$certificate = array (
 				'username'=>$_POST['username'],
 				'password'=>$_POST['password']
 				);
			if(Auth::attempt($certificate)) {
				return "Success";
			} else {
				return '用户名或密码错误!';
			} 			
 		} else {
 			return View::make("user/login")->with('title','Login');
 		}
 	}

	// handle logout action
 	public function logoutAction()
 	{
 		Auth::logout();
 		return Redirect::to('/login');
 	}
 }