<?php

namespace Gks\Application\ErrorHandling;

use Psr\Log\LoggerInterface;
use Whoops\Handler\Handler;

class LoggingHandler extends Handler
{
    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * @param LoggerInterface $log
     */
    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        $this->log->error($this->getException()->getMessage(), [
            'exception' => $this->getException(),
        ]);

        return Handler::DONE;
    }
}
