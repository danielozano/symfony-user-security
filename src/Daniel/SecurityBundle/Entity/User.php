<?php
// src/Daniel/SecurityBundle/Entity/User.php

namespace Daniel\SecurityBundle\Entity;

// Cargar librerías necesarias.

/**
 * Cargamos Doctrine (el ORM a utilizar), utilizaremos
 * las anotaciones para mapear las relaciones entre las propiedades
 * de nuestra entidad y las columnas de la base de datos.
 */
use Doctrine\ORM\Mapping as ORM;
/**
 * Esta clase será útil para añadir reglas de valicación, que se
 * ejecutarán antes de insertar en BBDD
 */
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Esta clase nos servirá para comprobar que ciertos valores de nuestro objeto entidad
 * son únicos en la tabla.
 */
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Interface de symfony que nos ayudará a definir ciertos métodos obligatorios
 * a la hora de tratar con usuarios.
 */
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Con estos comentarios estamos consiguiento los siguiente:
 * - Que esta clase es una entidad
 * - Que está relacionado con la tabla user
 * - Que su repositorio es UserRepository
 * - Que su propiedad username y email tengan valores únicos en la BBDD
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="username", message="This username is already in use")
 * @UniqueEntity(fields="email", message="This email is already in use")
 */
class User implements UserInterface, \Serializable
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	private $email;
	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 * @Assert\NotBlank()
	 */
	private $username;
	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;
	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;
	/**
	 * Atributo para tratar la contraseña, este no persistirá
	 * en base de datos.
	 */
	private $plainPassword;

	public function __construct()
	{
		$this->isActive = true;
	}
	/**
	 * Función heredad de la interface \Serializable, utilizada
	 * para serializar el objet User antes de introducirlo en 
	 * sesión.
	 * 
	 * @see \Serializable::serialize()
	 */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password
		));
	}
	/**
	 * Función heredada de la interface \Serializable, utilizada
	 * para obtener el objeto de sesión.
	 * 
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized)
	{
		list(
			$this->id,
			$this->username,
			$this->password
		) = unserialize($serialized);
	}
	/**
	 * Función heredada de UserInterface que obtiene el username del usuario.
	 * El username a utilizar puede configurarse en security.yml
	 */
	public function getUsername()
	{
		return $this->username;
	}
	/**
	 * Función heredada de UserInterface que obtiene la contraseña
	 * del usuario.
	 */
	public function getPassword()
	{
		return $this->password;
	}
	/**
	 * Función heredada de UserInterface que obtiene un array con los roles
	 * del usuario.
	 */
	public function getRoles()
	{
		return array('ROLE_USER');
	}
	/**
	 * Al utilizar bcrypt como algoritmo de encriptación, no es necesario
	 * añadir un salt antes de hashear la contraseña, ya que bcrypt lo hace
	 * internamente.
	 */
	public function getSalt()
	{
		return null;
	}
	/**
	 * Esta función heredada de UserInterface está pensada para borrar información
	 * sensible del objeto del usuario.
	 */
	public function eraseCredentials()
	{

	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setPlainPassword($plainPassword)
    {
    	$this->plainPassword = $plainPassword;
    }
    
    public function getPlainPassword()
	{
		return $this->plainPassword;
	}
}
