<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/user")
 */
class ApiAuthController extends AbstractController
{

    /**
     * @route(methods="GET")
     */
    public function currentUser(){
        return $this->json($this->getUser());
    }

    /**
     * @Route("/register", methods="POST")
     */
    public function register(Request $request, ObjectManager $om, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array(
            'csrf_protection' => false
        ));
        //$form->handleRequest() : a besoin d'un objet
        $form->submit(
            json_decode($request->getContent(), true),
            false
        );

        if($form->isSubmitted() && $form->isValid()){
          //Role user obligatoire pour cette route
            $user->setRoles(["ROLE_USER"]);
            $hashPassword = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hashPassword);

            $om->persist($user);
            $om->flush();

            //return $this->json($user, 201);
            return $this->json($user, Response::HTTP_CREATED);
        }

        return $this->json(["message"=>"user not registred " .$form->getErrors(true) ], Response::HTTP_BAD_REQUEST);
    }



}
