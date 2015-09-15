<?php

namespace AppBundle\Controller;

use AppBundle\CommandFormMapper\ReturnProductMapper;
use AppBundle\Forms\ReturnProductType;
use Rhumsaa\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductReturnController extends Controller
{
    /**
     * @Route("/returns/return", name="return_product")
     * @Method("GET")
     */
    public function returnAction()
    {
        $form = $this->createForm(new ReturnProductType(), new ReturnProductMapper());

        return $this->render(
            'returns/return.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/returns/return", name="process_return_product")
     * @Method("POST")
     */
    public function processReturnAction(Request $request)
    {
        $returnNumber = Uuid::uuid4();

        $form = $this->createForm(new ReturnProductType(), new ReturnProductMapper($returnNumber));
        $form->handleRequest($request);

        $this->get('symfony_live.pos.command_bus')->dispatch($form->getData()->createCommand());

        return new Response('Product return created with return number ' . $returnNumber);
    }
}
