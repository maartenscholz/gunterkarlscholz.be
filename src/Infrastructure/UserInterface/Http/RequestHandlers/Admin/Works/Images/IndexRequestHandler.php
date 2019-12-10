<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works\Images;

use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorksRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class IndexRequestHandler
{
    private Engine $templates;

    private WorksRepository $worksRepository;

    public function __construct(Engine $templates, WorksRepository $worksRepository)
    {
        $this->templates = $templates;
        $this->worksRepository = $worksRepository;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();
        $work = $this->worksRepository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/images/index', compact('work')));

        return $response;
    }
}
