<?php

namespace Gks\Application\ErrorHandling;

use League\Plates\Engine;
use Whoops\Handler\Handler;

class ErrorPageHandler extends Handler
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * @param Engine $templates
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        echo $this->templates->render('admin::error');

        return Handler::QUIT;
    }
}
