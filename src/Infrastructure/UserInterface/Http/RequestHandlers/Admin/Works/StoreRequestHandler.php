<?php

namespace Gks\Infrastructure\UserInterface\Http\RequestHandlers\Admin\Works;

use Aura\Session\Segment;
use Gks\Application\Commands\AddWork;
use Gks\Domain\Model\Works\Type;
use League\Tactician\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Sirius\Validation\Rule\InList;
use Sirius\Validation\Rule\Required;
use Sirius\Validation\Validator;
use Zend\Diactoros\Response\RedirectResponse;

class StoreRequestHandler
{
    /**
     * @var Segment
     */
    private $session;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param Segment $session
     * @param CommandBus $commandBus
     */
    public function __construct(Segment $session, CommandBus $commandBus)
    {
        $this->session = $session;
        $this->commandBus = $commandBus;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request)
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
}
