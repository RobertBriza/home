<?php

declare(strict_types=1);

namespace App\System\Application\Helper;

use App\System\Application\Wiring\Autowired;
use Contributte\Translation\LocalesResolvers\Session;
use Nette\Localization\Translator;

/** @SuppressWarnings(PHPMD.Superglobals) */
class CustomTranslator implements Autowired
{
	private Translator $translator;

	public function __construct(Translator $translator)
	{
		$this->translator = $translator;
	}

	public function getLocale(): string
	{
		return $_SESSION['__NF']['DATA'][Session::class]['locale'] ?? 'cs';
	}

	/** @param mixed[] ...$parameters */
	public function translate(string $message, array ...$parameters): string
	{
		$prefixedMessage = 'lng.' . $message;

		return $this->translator->translate($prefixedMessage, ...$parameters);
	}
}
