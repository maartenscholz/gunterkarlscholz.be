<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Gks\Domain\Works\WorkId;
use Gks\Domain\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImagesIndexRequestHandler
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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $work = $this->worksRepository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/images/index', compact('work')));

        return $response;
    }
}
