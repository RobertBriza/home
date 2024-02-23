<?php

namespace App\System\Application\Vite;

use Tracy\IBarPanel;

class VitePanel implements IBarPanel
{
    public function getTab()
    {
        return file_get_contents(__DIR__ . '/Vite.html');
    }

    public function getPanel()
    {
        return '';
    }
}
