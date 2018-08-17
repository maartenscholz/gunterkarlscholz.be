<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Model\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

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
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, array $args)
    {
        $response = new Response();

        $works = $this->repository->all();

        $response->getBody()->write($this->templates->render('admin::works/index', compact('works')));

        return $response;
    }
}
