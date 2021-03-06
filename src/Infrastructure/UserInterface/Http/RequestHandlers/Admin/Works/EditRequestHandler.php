<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Aura\Session\Segment;
use Gks\Domain\Model\Work;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Domain\Model\Works\WorkRepository;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditRequestHandler
{
    private Engine $templates;
    private WorkRepository $workRepository;
    private Segment $validationSession;

    public function __construct(Engine $templates, WorkRepository $workRepository, Segment $validationSession)
    {
        $this->templates = $templates;
        $this->workRepository = $workRepository;
        $this->validationSession = $validationSession;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $response = new Response();

        $work = $this->workRepository->findById(WorkId::fromString($args['id']));

        $response->getBody()->write($this->templates->render('admin::works/edit', $this->buildTemplateData($work)));

        return $response;
    }

    private function buildTemplateData(Work $work): array
    {
        $input = $this->validationSession->getFlash('input', []);

        return [
            'work' => $work,
            'type_options' => array_map(
                static function (Type $type) use ($input, $work) {
                    return [
                        'value' => $type->getValue(),
                        'label' => ucfirst($type->getValue()),
                        'selected' => isset($input['type']) ?
                            $input['type'] === $type->getValue() :
                            $work->getType()->getValue() === $type->getValue(),
                    ];
                },
                Type::all()
            ),
        ];
    }
}
