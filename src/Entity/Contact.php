<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\Length(min=2, max=100)
	 */
	private $firstname;

	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\Length(min=2, max=100)
	 */
	private $lastname;

	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\Regex(
	 	pattern="/[0-9]{10}/"
	 	)
	 */
	private $phone;

	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\Email
	 */
	private $email;

	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\length(min=10)
	 */
	private $message;

	/**
	 * @var Property|null
	 */
	private $property;


	/**
	 *  @return string|null
	 */
	public function getFirstname():?string
	{
		return $this->firstname;
	}

	/**
	 * @param string|null $firstname
	 * @return Contact
	 */
	public function setFirstname($firstname): Contact
	{
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 *  @return string|null
	 */
	public function getLastname():?string
	{
		return $this->lastname;
	}

	/**
	 * @param string|null $lastname
	 * @return Contact
	 */
	public function setLastname($lastname): Contact
	{
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 *  @return string|null
	 */
	public function getPhone():?string
	{
		return $this->phone;
	}

	/**
	 * @param string|null $phone
	 * @return Contact
	 */
	public function setPhone($phone): Contact
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 *  @return string|null
	 */
	public function getEmail():?string
	{
		return $this->email;
	}

	/**
	 * @param string|null $email
	 * @return Contact
	 */
	public function setEmail($email): Contact
	{
		$this->email = $email;
		return $this;
	}

	/**
	 *  @return string|null
	 */
	public function getMessage():?string
	{
		return $this->message;
	}

	/**
	 * @param string|null $message
	 * @return Contact
	 */
	public function setMessage($message): Contact
	{
		$this->message = $message;
		return $this;
	}

	/**
	 *  @return Property|null
	 */
	public function getProperty():Property
	{
		return $this->property;
	}

	/**
	 * @param string|null $property
	 * @return Contact
	 */
	public function setProperty($property): Contact
	{
		$this->property = $property;
		return $this;
	}


}