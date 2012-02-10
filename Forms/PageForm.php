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
use App\RegistrationModule\Entities\RegistrationEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class PageForm extends \Venne\Forms\PageForm
{

	public function startup()
	{
		parent::startup();
		$this->addGroup();
		$this->addSelect('verification', 'Way of verification', RegistrationEntity::$verifications);

		$this->addText("from", "From");
		$this["from"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL_AND_ADMIN)->addRule(self::FILLED, 'Enter e-mail');
		$this["from"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL)->addRule(self::FILLED, 'Enter e-mail');

		$this->addText("sender", "Sender name");
		$this["sender"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL_AND_ADMIN)->addRule(self::FILLED, 'Enter e-mail');
		$this["sender"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL)->addRule(self::FILLED, 'Enter e-mail');

		$this->addText("subject", "Subject");
		$this["subject"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL_AND_ADMIN)->addRule(self::FILLED, 'Enter the subject');
		$this["subject"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL)->addRule(self::FILLED, 'Enter the subject');

		$this->addEditor("text", "Template for e-mail")
			->setOption("description", 'Use: {$email} for user e-mail, {$password} for user password, {$link} for activation URL.');
		$this["text"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL_AND_ADMIN)->addRule(self::FILLED, 'Enter the text');
		$this["text"]->addConditionOn($this['verification'], self::EQUAL, RegistrationEntity::WITH_EMAIL)->addRule(self::FILLED, 'Enter the text');
	}



	protected function getParams()
	{
		return array("module" => "Registration", "presenter" => "Default", "action" => "default", "url" => isset($this->entity->url) ? $this->entity->url : NULL);
	}

}
