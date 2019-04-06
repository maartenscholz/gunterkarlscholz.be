<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use League\Plates\Engine;
use Whoops\Handler\Handler;

class ErrorPageHandler extends Handler
{
    /**
     * @var Engine
     */
    private $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    public function handle(): ?int
    {
        echo $this->templates->render('admin::error');

        return Handler::QUIT;
    }
}
