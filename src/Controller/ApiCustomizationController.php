<?php

namespace App\Controller;

use App\Entity\Customization;
use App\Form\CustomizationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/customization")
 */

class ApiCustomizationController extends AbstractController
{
    /**
     * @Route("/api/customization",  methods="POST")
     */
    public function registerForUser(Request $request, ObjectManager $om)
    {
        $user = $this->getUser();
        $custom = new Customization();

        $form = $this->createForm(CustomizationType::class, $custom, array(
            'csrf_protection' => false
        ));
        //$form->handleRequest() : a besoin d'un objet
        $form->submit(
            json_decode($request->getContent(), true),
            false
        );

        if($form->isSubmitted() && $form->isValid()){
           
            $custom->setUser($user);

            $om->persist($custom);
            $om->flush();

            //return $this->json($user, 201);
            return $this->json($user, Response::HTTP_CREATED);
        }

        return $this->json(["message"=>"Une erreur est survenue lors de l'enregistrement" .$form->getErrors(true) ], Response::HTTP_BAD_REQUEST);
    }

     /**
     * @Route("/{id}", methods="DELETE")
     */
    public function delete(Customization $custom, ObjectManager $manager)
    {
        $manager->remove($custom);
        $manager->flush();
       
        return $this->json(null, 204);
    }
}
