<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $voucherGenerator = $this->get('app.voucher_generator');
        $voucherGenerator->setNumCodesToGenerate(10);
        $voucherGenerator->setCodeLength(7);
        $voucherGenerator->setFileName('codes.txt');
        $voucherGenerator->generate();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
