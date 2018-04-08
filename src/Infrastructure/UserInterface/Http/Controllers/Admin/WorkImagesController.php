<?php

namespace Gks\Infrastructure\UserInterface\Http\Controllers\Admin;

use Gks\Domain\Works\WorkId;
use Gks\Domain\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WorkImagesController
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * @var WorksRepository
     */
    private $worksRepository;

    /**
     * @param Engine $templates
     * @param WorksRepository $worksRepository
     */
    public function __construct(Engine $templates, WorksRepository $worksRepository)
    {
        $this->templates = $templates;
        $this->worksRepository = $worksRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $work = $this->worksRepository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/images/index', compact('work')));

        return $response;
    }
}