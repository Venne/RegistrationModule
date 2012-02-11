<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace App\RegistrationModule\Entities;

use Venne;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BaseRegistrationEntity extends \App\CoreModule\Entities\BasePageEntity
{

	const WITHOUT_EMAIL = "without email";

	const WITH_EMAIL = "with email";

	const WITH_EMAIL_AND_ADMIN = "with email and admin";

	/** @var array */
	public static $verifications = array(
		self::WITHOUT_EMAIL => "Without e-mail",
		self::WITH_EMAIL => "With email",
		self::WITH_EMAIL_AND_ADMIN => "With e-mail and administrator",
	);

	/** @Column(type="string") */
	protected $verification;

	/** @Column(type="string") */
	protected $sender;

	/** @Column(type="string", name="`from`") */
	protected $from;

	/** @Column(type="string") */
	protected $subject;

	/** @Column(type="text") */
	protected $text;

	const LINK = "Registration:Default:default";


	public function __construct()
	{
		$this->sender = "";
		$this->from = "";
		$this->subject = "";
		$this->text = '<p>Thank your for your registration.</p>
			<p>Your registration informations:</p>

			<strong>E-mail:</strong> {$email}<br />
			<strong>Password:</strong> {$password}

			<p>
				Please activate your account here: {$link}
			</p>';
	}


	public function setText($text)
	{
		$this->text = $text;
	}



	public function getText()
	{
		return $this->text;
	}



	public function setVerification($verification)
	{
		if (!isset(self::$verifications[$verification])) {
			throw new \Nette\InvalidArgumentException;
		}

		$this->verification = $verification;
	}



	public function getVerification()
	{
		return $this->verification;
	}



	public function setFrom($from)
	{
		$this->from = $from;
	}



	public function getFrom()
	{
		return $this->from;
	}



	public function setSender($sender)
	{
		$this->sender = $sender;
	}



	public function getSender()
	{
		return $this->sender;
	}



	public function setSubject($subject)
	{
		$this->subject = $subject;
	}



	public function getSubject()
	{
		return $this->subject;
	}

}
