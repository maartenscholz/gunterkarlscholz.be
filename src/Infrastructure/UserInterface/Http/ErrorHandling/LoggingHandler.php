<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use Psr\Log\LoggerInterface;
use Whoops\Handler\Handler;

final class LoggingHandler extends Handler
{
    private LoggerInterface $log;

    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    public function handle(): ?int
    {
        $this->log->error(
            $this->getException()->getMessage(),
            [
                'exception' => $this->getException(),
            ]
        );

        return Handler::DONE;
    }
}
