<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;
use App\Form\UrlFormType;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $model = new Url();
        $form = $this->createForm(UrlFormType::class, $model);
        $form->handleRequest($request);

        $link = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($model);
            $entityManager->flush();
            $link = $model->getId() . ' created';
        }

        return $this->render('site/index.html.twig', [
            'link' => $link,
            'form' => $form->createView()
        ]);
    }
}
