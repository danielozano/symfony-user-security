<?php
// src/Daniel/SecurityBundle/Controller/UserController.php

namespace Daniel\SecurityBundle\Controller;

use Daniel\SecurityBundle\Entity\User;
use Daniel\SecurityBundle\Form\Type\UserRegisterType;
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
		// Crear nuevo objeto entidad
		$user = new User();
		/**
		 * Crear el objeto formulario (nuestra propia clase), se le pueden pasar opciones
		 * adicionales. En este caso vamos a pasarle un nuevo action aunque no sería
		 * necesario en este caso
		 */
		$formOptions = array('action' => $this->generateUrl('daniel_security_user_register'));
		$form = $this->createForm(UserRegisterType::class, $user, $formOptions);
		// añadir handler al formulario, asi en caso de que se haga submit podemos
		// detectarlo y obtener sus datos
		$form->handleRequest($request);
		var_dump($form->isSubmitted());
		var_dump($form->isValid());
		// si la información del formulario es válida persistir en base de datos
		if ($form->isSubmitted() && $form->isValid())
		{
			$user = $form->getData();
			// obtener la contraseña en texto plano y encriptarla
			$password = $this->get('security.password_encoder')
				->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);
			/**
			 * Ya tenemos el objeto entidad user con todos sus datos, y listo
			 * para persistirlo en la base de datos, para lo cual necesitamos
			 * el entity manager de doctrine
			 */
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
		}
		return $this->render(
			'DanielSecurityBundle:User:register.html.twig',
			array(
				'form' => $form->createView(),
			)
		);
	}
}