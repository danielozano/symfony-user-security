<?php
// src/Daniel/SecurityBUndle/Form/Type/UserType.php

namespace Daniel\SecurityBundle\Form\Type;
/**
 * La clase AbstracType nos otorgará los métodos necesarios para poder
 * construir nuestra clase formulario.
 *
 * FormBuilderInterface nos proporcionará un objeto mediante el cual
 * podremos crear los inputs de nuestro objeto formulario.
 *
 * OptionsResolver nos permitirá añadir restricciones y opciones
 * a nuestro objeto. Aquí lo utilizaremos para comprobar que los datos
 * recibidos coinciden con nuestra entidad.
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Hay que cargar una clase por cada tipo de input que
 * deseemos utilizar en nuestro objeto formulario.
 */
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * En esta clase estamos creando un tipo de formulario adecuado
 * para registrar usuarios, que será reutilizable en cualquier
 * parte de la apliación
 */
class UserRegisterType extends AbstractType
{
	/**
	 * Mediante este método se determinan las opciones y su tipo, las 
	 * cuales formarán nuestro formulario.
	 * 
	 * @param  FormBuilderInterface $builder Objeto para construir el formulario
	 * @param  array                $options 
	 */
	public function buildform(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class)
			->add('username', TextType::class)
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options' => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password')
			)
		);
	}
	/**
	 * El OptionsResolver nos permitirá crear un sistema de opciones
	 * con validación, normalización, defautls y mucho más.
	 */
	public function getConfigureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Daniel\SecurityBudnle\Entity\User'
		));
	}
}