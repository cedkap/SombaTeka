<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function Register (UserPasswordEncoderInterface $encoder,Request $request)
    {
        $user = new User();
        //hash le mots de passe
        $loginForm =$this->createForm(UserType::class,$user);
        $loginForm->handleRequest($request);
        if ($loginForm ->isSubmitted() && $loginForm->isValid()){
            //mot de passe
            $password = $user->getPassword();
            $hash = $encoder->encodePassword($user,$password);
            $user->setPassword($hash);

            //execution de la classe
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //
            $this->addFlash('success','merci pour votre inscription');
            //rediriger la page
            return $this->redirectToRoute('home' );
        }

        return $this->render('security/index.html.twig',['loginFrom'=>$loginForm->createView()]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     */
   /* public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }*/
}
