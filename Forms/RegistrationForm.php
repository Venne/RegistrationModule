<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace App\RegistrationModule\Forms;

use Venne\Forms\Mapping\EntityFormMapper;
use Doctrine\ORM\EntityManager;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class RegistrationForm extends \Venne\Forms\EntityForm
{

	public function startup()
	{
		parent::startup();

		$this->addGroup();
		$this->addText("email", "E-mail:")->addRule(\Nette\Forms\Form::EMAIL, "Enter email");
		$this->addPassword("password", "Password:")
			->setRequired('Enter the password')
			->addRule(\Nette\Forms\Form::MIN_LENGTH, 'Password is short', 5);
		$this->addPassword("pass2", "Confirm password:")
			->addRule(self::EQUAL, 'Invalid re password', $this['password']);
	}

}
