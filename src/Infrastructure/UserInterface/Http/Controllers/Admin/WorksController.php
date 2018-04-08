<?php

namespace Gks\Infrastructure\UserInterface\Http\Controllers\Admin;

use Aura\Session\Segment;
use Gks\Application\Commands\AddWork;
use Gks\Application\Commands\RemoveWork;
use Gks\Application\Commands\UpdateWork;
use Gks\Domain\Works\Type;
use Gks\Domain\Works\WorkId;
use Gks\Infrastructure\UserInterface\Http\Validation\MatchNotEmpty;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sirius\Validation\Rule\GreaterThan;
use Sirius\Validation\Rule\InList;
use Sirius\Validation\Rule\Required;
use Sirius\Validation\Validator;
use Zend\Diactoros\Response\RedirectResponse;

class WorksController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var Segment
     */
    private $session;

    /**
     * @param CommandBus $commandBus
     * @param Segment $session
     */
    public function __construct(CommandBus $commandBus, Segment $session)
    {
        $this->commandBus = $commandBus;
        $this->session = $session;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return RedirectResponse
     */
    public function store(ServerRequestInterface $request)
    {
        $validator = new Validator();

        $validator->add('type', Required::class);
        $validator->add('type', InList::class, [InList::OPTION_LIST => Type::TYPES]);
        $validator->add('title[nl_BE]', Required::class);
        $validator->add('title[en_US]', Required::class);
        $validator->add('title[fr_FR]', Required::class);
        $validator->add('title[de_DE]', Required::class);

        if (!$validator->validate($request->getParsedBody())) {
            $this->session->setFlash('errors', $validator->getMessages());
            $this->session->setFlash('input', $request->getParsedBody());

            return new RedirectResponse('/admin/works/create');
        }

        $this->commandBus->handle(AddWork::fromRequest($request));

        return new RedirectResponse('/admin/works');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return RedirectResponse
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $validator = new Validator();

        $validator->add('type', Required::class);
        $validator->add('type', InList::class, [InList::OPTION_LIST => Type::TYPES]);
        $validator->add('title[nl_BE]', Required::class);
        $validator->add('title[en_US]', Required::class);
        $validator->add('title[fr_FR]', Required::class);
        $validator->add('title[de_DE]', Required::class);
        $validator->add('width', GreaterThan::class, [GreaterThan::OPTION_MIN => 0]);
        $validator->add('height', GreaterThan::class, [GreaterThan::OPTION_MIN => 0, GreaterThan::OPTION_INCLUSIVE]);
        $validator->add('width', MatchNotEmpty::class, [MatchNotEmpty::OPTION_ITEM => 'height']);
        $validator->add('height', MatchNotEmpty::class, [MatchNotEmpty::OPTION_ITEM => 'width']);

        if (!$validator->validate($request->getParsedBody())) {
            $this->session->setFlash('errors', $validator->getMessages());
            $this->session->setFlash('input', $request->getParsedBody());

            return new RedirectResponse('/admin/works/'.$args['id'].'/edit');
        }

        $this->commandBus->handle(UpdateWork::fromRequest(WorkId::fromString($args['id']), $request));

        return new RedirectResponse('/admin/works');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    public function destroy(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->commandBus->handle(new RemoveWork(WorkId::fromString($args['id'])));

        return new RedirectResponse('/admin/works');
    }
}