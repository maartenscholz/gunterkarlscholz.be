<?php

namespace Gks\Application\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexRequestHandler
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * @var WorksRepository
     */
    private $repository;

    /**
     * @param Engine $templates
     * @param WorksRepository $repository
     */
    public function __construct(Engine $templates, WorksRepository $repository)
    {
        $this->templates = $templates;
        $this->repository = $repository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $works = $this->repository->all();

        $response->getBody()->write($this->templates->render('admin::works/index', compact('works')));

        return $response;
    }
}
