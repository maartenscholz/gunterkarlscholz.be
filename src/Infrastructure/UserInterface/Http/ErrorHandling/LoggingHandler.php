<?php

namespace Gks\Infrastructure\UserInterface\Http\ErrorHandling;

use League\Route\Http\Exception\HttpExceptionInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use Whoops\Handler\Handler;

final class LoggingHandler extends Handler
{
    private LoggerInterface $log;

    private static array $blacklist = [
        HttpExceptionInterface::class,
    ];

    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    public function handle(): ?int
    {
        $exception = $this->getException();

        if ($this->shouldNotLog($exception)) {
            return self::DONE;
        }

        $this->log->error(
            $exception->getMessage(),
            [
                'exception' => $exception,
            ]
        );

        return Handler::DONE;
    }

    private function shouldNotLog(Throwable $exception): bool
    {
        foreach (self::$blacklist as $exceptionClass) {
            if (is_a($exception, $exceptionClass)) {
                return true;
            }
        }

        return false;
    }
}
