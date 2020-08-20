<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Aura\Session\Segment;
use Gks\Application\Commands\UpdateWork;
use Gks\Domain\Model\Works\Type;
use Gks\Domain\Model\Works\WorkId;
use Gks\Infrastructure\UserInterface\Http\Validation\MatchNotEmpty;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sirius\Validation\Rule\GreaterThan;
use Sirius\Validation\Rule\InList;
use Sirius\Validation\Rule\Required;
use Sirius\Validation\Validator;

final class UpdateRequestHandler
{
    private Segment $session;

    private CommandBus $commandBus;

    public function __construct(Segment $session, CommandBus $commandBus)
    {
        $this->session = $session;
        $this->commandBus = $commandBus;
    }

    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $validator = $this->getValidator();

        if (!$validator->validate($request->getParsedBody())) {
            $this->session->setFlash('errors', $validator->getMessages());
            $this->session->setFlash('input', $request->getParsedBody());

            return new RedirectResponse('/admin/works/'.$args['id'].'/edit');
        }

        $this->commandBus->handle(UpdateWork::fromRequest(WorkId::fromString($args['id']), $request));

        return new RedirectResponse('/admin/works');
    }

    private function getValidator(): Validator
    {
        $validator = new Validator();

        $validator->add('type', Required::class);
        $validator->add('type', InList::class, [InList::OPTION_LIST => array_map(static function (Type $type) { return $type->getValue(); }, Type::all())]);
        $validator->add('title[nl_BE]', Required::class);
        $validator->add('title[en_US]', Required::class);
        $validator->add('title[fr_FR]', Required::class);
        $validator->add('title[de_DE]', Required::class);
        $validator->add('width', GreaterThan::class, [GreaterThan::OPTION_MIN => 0]);
        $validator->add('height', GreaterThan::class, [GreaterThan::OPTION_MIN => 0, GreaterThan::OPTION_INCLUSIVE]);
        $validator->add('width', MatchNotEmpty::class, [MatchNotEmpty::OPTION_ITEM => 'height']);
        $validator->add('height', MatchNotEmpty::class, [MatchNotEmpty::OPTION_ITEM => 'width']);

        return $validator;
    }
}
