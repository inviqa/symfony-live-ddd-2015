<?php

namespace AppBundle\Controller;

use AppBundle\CommandFormMapper\ReturnProductMapper;
use AppBundle\Forms\ReturnProductType;
use Rhumsaa\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SymfonyLive\Pos\Returns\RefundForCash;
use SymfonyLive\Pos\Returns\RefundForCredit;
use SymfonyLive\Pos\Returns\ReturnNumber;

class RefundController extends Controller
{

    /**
     * @Route("/returns/refund", name="refund_return")
     * @Method("POST")
     */
    public function refundReturnAction(Request $request)
    {
        $returnNumber = new ReturnNumber(Uuid::fromString($request->request->get('return_number')));

        if ('credit' == $request->request->get('return_type')) {
            $command = new RefundForCredit($returnNumber);
        }
        else {
            $command = new RefundForCash($returnNumber);
        }

        $this->get('symfony_live.pos.command_bus')->dispatch($command);

        return $this->redirect($this->generateUrl('outstanding'));
    }
}
