<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Haus;
use App\Form\NewHausFormType;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(): Response
    {
        $haeuser = $this->getDoctrine()->getRepository(Haus::class)->findAll();
        return $this->render('homepage/homepage.html.twig', [
            'haeuser' => $haeuser,
        ]);
    }

    /**
     * @Route("/datenschutz", name="app_homepage_datenschutz")
     */
    public function homepage_datenschutz(): Response
    {
        return $this->render('homepage/datenschutz.html.twig', []);
    }

    /**
     * @Route("/impressum", name="app_homepage_impressum")
     */
    public function homepage_impressum(): Response
    {
        return $this->render('homepage/impressum.html.twig', []);
    }

    /**
     * @Route("/fehlalarm", name="app_homepage_fehlalarm")
     */
    public function homepage_fehlalarm(): Response
    {
        return $this->render('homepage/fehlalarm.html.twig', []);
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin(Request $request): Response
    {
        
        $haus = new Haus();
        $form = $this->createForm(NewHausFormType::class, $haus);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $haus = $form->getData();
            $suchstring = \urlencode($haus->getAdresse() . ', ' . $haus->getPlz() . ', ' . $haus->getOrt() . ', Deutschland');
            $apiResponse = json_decode(file_get_contents('https://api.opencagedata.com/geocode/v1/json?q=' . $suchstring . '&key=67c72c4de30e4c54b6bb84ff6cefcb28'));
            $haus->setLat($apiResponse->results[0]->geometry->lat);
            $haus->setLng($apiResponse->results[0]->geometry->lng);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($haus);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('app_admin'));
        }
        $haeuser = $this->getDoctrine()->getRepository(Haus::class)->findAll();
        return $this->render('admin/admin.html.twig', [
            'haeuser' => $haeuser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/haus/{id}/delete", name="app_admin_delete")
     */
    public function admin_delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $haus = $this->getDoctrine()->getRepository(Haus::class)->findOneById($id);
        $entityManager->remove($haus);       
        $entityManager->flush();
        return $this->redirect($this->generateUrl('app_admin')); 
    }
    
}