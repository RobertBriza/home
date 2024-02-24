<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use Nette;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{
	public function beforeRender(): void
	{
		parent::beforeRender();
	}

	public function formSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
	{
		$this->flashMessage('Skóre uloženo.');
		$this->redirect('this');
	}

	protected function createComponentDayScore(): ?Nette\ComponentModel\IComponent
	{
		$form = new Form;
		$form->addSelect('score1', 'Hodnocení 1', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSelect('score2', 'Hodnocení 2', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}
}
