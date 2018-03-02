<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Url;
use AppBundle\Form\UrlType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUrl = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$url = $entityManager->getRepository(Url::class)->findOneByFullUrl($newUrl->getFullUrl())) {
                $entityManager->persist($newUrl);
                $entityManager->flush();

                $url = $newUrl;
            }

            return $this->redirectToRoute('confirmation', [
                'id' => $url->getHash()
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirmation/{id}", name="confirmation")
     * @ParamConverter("url", class="AppBundle:Url", options={"repository_method" = "findOneByHash"})
     */
    public function confirmationAction(Request $request, Url $url)
    {
        return $this->render('default/confirmation.html.twig', [
            'url' => $url
        ]);
    }

    /**
     * @Route("/{id}", name="redirect")
     * @ParamConverter("url", class="AppBundle:Url", options={"repository_method" = "findOneByHash"})
     */
    public function redirectAction(Request $request, Url $url)
    {
        return $this->redirect($url->getFullUrl());
    }
}
