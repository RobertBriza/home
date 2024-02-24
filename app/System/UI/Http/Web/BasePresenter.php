<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Nameday\Infrastructure\DayInfoProvider;
use app\System\Application\CQRS\Bus;
use app\System\Application\Helper\CustomTranslator;
use app\System\Application\Vite\Vite;
use app\System\UI\Http\Web\Template\BaseTemplate;
use Contributte;
use DateTimeImmutable;
use Nette;

/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @inject */
	public CustomTranslator $t;
	/** @inject */
	public Contributte\Translation\LocalesResolvers\Session $translatorSessionResolver;

	public function __construct(
		protected Bus $bus,
		private Vite $vite,
		private DayInfoProvider $dayInfoProvider,
	) {
	}

	public function beforeRender(): void
	{
		$this->template->dayInfoDTO = $this->dayInfoProvider->get(new DateTimeImmutable());
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