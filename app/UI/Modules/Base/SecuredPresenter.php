<?php declare(strict_types = 1);

namespace App\UI\Modules\Base;

use App\Model\App;
use Nette\Security\User;

abstract class SecuredPresenter extends BasePresenter
{

	public function checkRequirements(mixed $element): void
	{
		if (!$this->user->isLoggedIn()) {
			if ($this->user->getLogoutReason() === User::LogoutInactivity) {
				$this->flashInfo('You have been logged out for inactivity');
			}

			$this->redirect(
				App::DESTINATION_SIGN_IN,
				['backlink' => $this->storeRequest()]
			);
		}
	}

}
