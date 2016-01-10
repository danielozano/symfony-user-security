<?php
// src/Daniel/SecurityBundle/Controller/UserController.php

namespace Daniel\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
	public function loginAction(Request $request)
	{
		return new Response('Login Action');
	}

	public function registerAction(Request $request)
	{
		return new Response('Register Action');
	}
}