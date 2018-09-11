<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\VoucherListType;
use AppBundle\Entity\VoucherList;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $voucherList = new VoucherList();
        $form = $this->createForm(VoucherListType::class, $voucherList);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $voucherGenerator = $this->get('app.voucher_generator');
            $voucherGenerator->setVoucherList($voucherList);
            $voucherGenerator->generate();
        }

        return $this->render('home.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
