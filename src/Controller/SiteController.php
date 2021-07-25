<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;
use App\Form\UrlFormType;
use App\Repository\UrlRepository;

class SiteController extends AbstractController
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $model = new Url();
        $form = $this->createForm(UrlFormType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('success', [
                'url' => $model->getNewLink()
            ]);
        }

        return $this->render('site/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/success/{url}", name="success")
     */
    public function success(string $url): Response
    {
        $model = $this->urlRepository->findOneByNewLink($url);
        $message = $model ? 'Short Link:' . $model->getNewLink() : 'Short Link not found';

        return $this->render('site/success.html.twig', [
            'link' => $message
        ]);
    }

    /**
     * @Route("/{url}")
     */
    public function toPage(string $url): Response
    {
        $url = $this->urlRepository->findOneByNewLink($url);

        if ($url) {
            return $this->redirect('http://' . $url->getOriginalUrl());
        }

        return $this->redirectToRoute('index');
    }
}
