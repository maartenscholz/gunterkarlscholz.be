<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Model\Works\WorkRepository;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class IndexRequestHandler
{
    private Engine $templates;

    private WorkRepository $repository;

    public function __construct(Engine $templates, WorkRepository $workRepository)
    {
        $this->templates = $templates;
        $this->repository = $workRepository;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();

        $works = $this->repository->all();

        $response->getBody()->write($this->templates->render('admin::works/index', compact('works')));

        return $response;
    }
}
