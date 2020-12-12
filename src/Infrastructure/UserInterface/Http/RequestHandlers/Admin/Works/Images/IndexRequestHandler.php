<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\Images;

use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorkRepository;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class IndexRequestHandler
{
    private Engine $templates;

    private WorkRepository $workRepository;

    public function __construct(Engine $templates, WorkRepository $workRepository)
    {
        $this->templates = $templates;
        $this->workRepository = $workRepository;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        $work = $this->workRepository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/images/index', compact('work')));

        return $response;
    }
}
