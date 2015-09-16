<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SymfonyLive\Pos\ReadModel\Returns\OutstandingReturn;

class OutstandingReturnController extends Controller
{
    /**
     * @Route("/returns/outstanding", name="outstanding")
     */
    public function outstandingAction()
    {
        $returns = $this->container->get('symfony_live.pos.read_model.outstanding_returns')->findAll();

        return $this->render('returns/overdue.html.twig', ['returns' => $returns]);
    }
}
