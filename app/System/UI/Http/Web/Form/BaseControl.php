<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;
use Nette\FileNotFoundException;
use ReflectionClass;

/**
 * @property DefaultTemplate $template
 */
abstract class BaseControl extends Control
{
	public function render(mixed ...$args): void
	{
		if ($args) {
			dumpe($args);
		}

		$this->prepareTemplate();

		//TODO: user verification

		$this->template->render();
	}

	protected function prepareTemplate(): void
	{
		[$slashLocation, $dotLocation] = $this->presenter->formatTemplateFiles();

		$pathInfo = pathinfo($slashLocation);

		if (isset($pathInfo['dirname']) === false) {
			return;
		}

		$controlName = lcfirst((new ReflectionClass(static::class))->getShortName());
		$templateFile =
			sprintf(
				'%s/components/%s.latte',
				$pathInfo['dirname'],
				$controlName,
			);

		if (file_exists($templateFile) === false) {
			throw new FileNotFoundException(sprintf(
				'Template file %s for control %s does not exist',
				$templateFile,
				$controlName,
			));
		}

		$this->template->setFile($templateFile);
	}
}
