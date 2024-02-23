<?php

declare(strict_types=1);

namespace App\System\UI\Http\Web;

use App\System\Application\CQRS\Bus;
use App\System\Application\Helper\CustomTranslator;
use App\System\Application\Vite\Vite;
use Contributte;
use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @inject */
	public CustomTranslator $t;
	/** @inject */
	public Contributte\Translation\LocalesResolvers\Session $translatorSessionResolver;

	public function __construct(
		protected Bus $bus,
		private Vite $vite,
	) {
	}

	public function beforeRender(): void
	{
		$this->template->vite = $this->vite;
	}

	public function handleChangeLocale(): void
	{
		$defaultLocale = 'cs';

		$locale = $this->t->getLocale() === $defaultLocale ? 'en' : $defaultLocale;

		$this->translatorSessionResolver->setLocale($locale);
		$this->redirect('this');
	}

	protected function startup(): void
	{
		parent::startup();
		$this->getSession()->start();
	}
}
