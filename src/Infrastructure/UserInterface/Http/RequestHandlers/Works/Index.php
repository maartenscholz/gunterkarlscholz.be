<?php

declare(strict_types=1);

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Works;

use Gks\Domain\Model\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class Index
{
    private Engine $templates;

    private WorksRepository $repository;

    public function __construct(Engine $templates, WorksRepository $repository)
    {
        $this->templates = $templates;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();

        $works = $this->repository->all();

        $response->getBody()->write($this->templates->render('works/index', compact('works')));

        return $response;
    }
}
