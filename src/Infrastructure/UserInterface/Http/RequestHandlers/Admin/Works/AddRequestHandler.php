<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Aura\Session\Segment;
use Gks\Domain\Model\Works\Type;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddRequestHandler
{
    private Engine $templates;
    private Segment $validationSession;

    public function __construct(Engine $templates, Segment $validationSession)
    {
        $this->templates = $templates;
        $this->validationSession = $validationSession;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $response->getBody()->write($this->templates->render('admin::works/create', $this->buildTemplateData()));

        return $response;
    }

    private function buildTemplateData(): array
    {
        $input = $this->validationSession->getFlash('input', []);

        return [
            'type_options' => array_map(
                static function (Type $type) use ($input) {
                    return [
                        'value' => $type->getValue(),
                        'label' => ucfirst($type->getValue()),
                        'selected' => isset($input['type']) ? $input['type'] === $type->getValue() : false,
                    ];
                },
                Type::all()
            ),
        ];
    }
}
