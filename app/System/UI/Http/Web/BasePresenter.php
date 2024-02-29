<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Day\Infrastructure\DayInfoProvider;
use app\System\Application\CQRS\CQRS;
use app\System\Application\CQRS\CQRSAble;
use app\System\Application\Helper\CustomTranslator;
use app\System\Application\Vite\Vite;
use app\System\UI\Http\Web\Template\BaseTemplate;
use Contributte;
use DateTimeImmutable;
use Nette\Application\UI\Presenter;

/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Presenter implements CQRSAble
{
	use CQRS;

	/** @inject */
	public CustomTranslator $t;
	/** @inject */
	public Contributte\Translation\LocalesResolvers\Session $translatorSessionResolver;
	protected DayInfoProvider $dayInfoProvider;
	protected Vite $vite;

	public function beforeRender(): void
	{
		$this->template->dayInfoDTO = $this->dayInfoProvider->get(new DateTimeImmutable());
		$this->template->vite = $this->vite;

		$this->redrawControl('title');
		$this->redrawControl('content');
		$this->redrawControl('flashes');
	}

	public function handleChangeLocale(): void
	{
		$defaultLocale = 'cs';

		$locale = $this->t->getLocale() === $defaultLocale ? 'en' : $defaultLocale;

		$this->translatorSessionResolver->setLocale($locale);
		$this->redirect('this');
	}

	public function setDayInfoProvider(DayInfoProvider $dayInfoProvider): void
	{
		$this->dayInfoProvider = $dayInfoProvider;
	}

	public function setVite(Vite $vite): void
	{
		$this->vite = $vite;
	}

	protected function startup(): void
	{
		parent::startup();
		$this->getSession()->start();
	}
}
