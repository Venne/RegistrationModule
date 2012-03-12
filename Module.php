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

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class Module extends \Venne\Module\BaseModule
{


	/** @var string */
	protected $description = "Registrate users.";

	/** @var string */
	protected $version = "1.0";



	public function configure(\Nette\DI\Container $container)
	{
		parent::configure($container);

		$container->core->cmsManager->addContentType(Entities\RegistrationEntity::LINK, "registration page", array("url"), $container->registration->registrationRepository, function() use($container)
		{
			return $container->registration->createPageForm();
		});
	}

}
