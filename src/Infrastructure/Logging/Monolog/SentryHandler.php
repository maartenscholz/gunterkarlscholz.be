<?php

namespace Gks\Infrastructure\Logging\Monolog;

use Monolog\Handler\AbstractProcessingHandler;
use Sentry\Client;
use Sentry\State\Scope;
use Throwable;

class SentryHandler extends AbstractProcessingHandler
{
    /**
     * @var Client
     */
    private $sentryClient;

    public function __construct(Client $sentryClient)
    {
        $this->sentryClient = $sentryClient;

        parent::__construct();
    }

    protected function write(array $record): void
    {
        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof Throwable) {
            $this->sentryClient->captureException($record['context']['exception'], new Scope());
        } else {
            $this->sentryClient->captureMessage($record['formatted']);
        }
    }
}
