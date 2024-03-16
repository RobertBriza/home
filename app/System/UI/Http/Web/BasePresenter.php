<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Day\Application\Query\GetDayDTOByValue;
use app\Day\Infrastructure\DayInfoProvider;
use app\System\Application\CQRS\CQRS;
use app\System\Application\CQRS\CQRSAble;
use app\System\Application\Helper\CustomTranslator;
use app\System\Application\Vite\Vite;
use app\System\UI\Http\Web\Template\BaseTemplate;
use Contributte;
use DateTimeImmutable;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;
use Nette\Caching\Cache;

/**
 * @property-read BaseTemplate $template
 */
abstract class BasePresenter extends Presenter implements CQRSAble
{
	use CQRS;

	/** @inject */
	public Cache $cache;
	/** @inject */
	public CustomTranslator $t;
	public DateTimeImmutable $today;
	/** @inject */
	public Contributte\Translation\LocalesResolvers\Session $translatorSessionResolver;
	protected DayInfoProvider $dayInfoProvider;
	protected Vite $vite;

	public function beforeRender(): void
	{
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

	protected function getPost(): mixed
	{
		if (json_validate($this->getHttpRequest()->getRawBody()) === false) {
			$this->sendResponse(new JsonResponse(['response' => 'Invalid JSON']));
		}

		return json_decode($this->getHttpRequest()->getRawBody(), true);
	}

	protected function startup(): void
	{
		parent::startup();
		$this->getSession()->start();

		$this->today = new DateTimeImmutable();

		$this->template->todayDTO = $this->cache->load(
			'dayInfo' . $this->today->format('Y-m-d'),
			fn () => $this->sendQuery(new GetDayDTOByValue($this->today)),
			[Cache::Expire => '30 days'],
		);

		$this->template->vite = $this->vite;
	}
}
