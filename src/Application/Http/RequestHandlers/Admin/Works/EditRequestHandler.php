<?php

namespace Gks\Application\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Works\WorkId;
use Gks\Domain\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EditRequestHandler
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
        $work = $this->repository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/edit', compact('work')));

        return $response;
    }
}
