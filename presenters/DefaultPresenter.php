<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace App\RegistrationModule;

use Venne;
use App\RegistrationModule\Entities\RegistrationEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 *
 * @secured
 */
class DefaultPresenter extends \Venne\Application\UI\PagePresenter
{


	/** @var \Venne\Doctrine\ORM\BaseRepository */
	protected $repository;



	public function startup()
	{
		parent::startup();

		$this->repository = $this->context->core->userRepository;

		if ($this->getParameter("key")) {
			$this->setView("confirm");
		}
	}



	public function createComponentForm()
	{
		$repository = $this->repository;
		$entity = $repository->createNew();

		$form = $this->context->registration->createRegistrationForm();
		$form->setEntity($entity);
		$form->addSubmit("_submit", "Registrate");
		$form->onSuccess[] = function($form) use ($repository)
		{
			if ($form->presenter->page->verification != RegistrationEntity::WITHOUT_EMAIL) {
				$form->presenter->sendEmail($form->entity);
				$form->presenter->flashMessage("Your account has been created, check your e-mail and confirm it.");
			} else {
				$form->entity->enable = true;
				$form->presenter->flashMessage("Your account has been created and activated.");
			}
			$repository->save($form->entity);
			$form->presenter->redirect("this");
		};
		return $form;
	}



	public function sendEmail(\App\CoreModule\Entities\UserEntity $user)
	{
		$link = $this->context->parameters["basePath"] . $this->link("this", array("key"=>$user->key));

		$text = $this->page->text;
		$text = strtr($text, array(
			'{$email}' => $user->email,
			'{$password}' => $user->password,
			'{$link}' => '<a href="'.$link.'">'.$link.'</a>'
		));

		$mail = $this->context->nette->createMail();
		$mail->setFrom("{$this->page->sender} <{$this->page->from}>")
			->addTo($user->email)
			->setSubject($this->page->subject)
			->setHTMLBody($text)
			->send();
	}



	public function renderConfirm()
	{
		$user = $this->repository->findOneByKey($this->getParameter("key"));
		if (!$user) {
			$this->setView("error");
		} else {
			$user->key = "";
			if ($form->presenter->page->verification == RegistrationEntity::WITH_EMAIL) {
				$user->enable = true;
				$this->template->activated = true;
			}
			$this->repository->save($user);
			$this->template->entity = $user;
		}
	}

}