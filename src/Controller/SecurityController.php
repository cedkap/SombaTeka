<?php

namespace App\Controller;

use App\Entity\Advert;
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

    // lister les messages de l'utilisateur
    /**
     * @Route(
     *     "/Moncompte",
     *     name="user_list",
     *      methods={"GET"}
     *     )
     */
    public function list()
    {

        //on recuperer les parametre du de l'utlisateur X
        $Userpar =$this->getUser();

        //Question du l'utilisateur X
        $userAdvertRepository = $this->getDoctrine()->getRepository(User::class);
        //on recuperer les parametre du de l'utlisateur X
        $userAdvert = $userAdvertRepository->findListAdvert($Userpar);

        //Message du l'utilisateur X
        /*$UserMessageRepository = $this->getDoctrine()->getRepository(User::class);
        $userMessage = $UserMessageRepository->findListMessage($Userpar);*/

        //



        return $this->render('security/moncompte.html.twig',['userAdvert'=>$userAdvert]);
    }

    // Supprimer un element
    /**
     * @Route(
     *     "/Supprimer/{{id}}",
     *     name="user_delete", requirements ={"id":"\d+"}
     *      ,methods={"GET"}
     *     )
     */
    public function deleteAdvert($id){
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository(Advert::class)->find($id);
        $em->remove($obj);
        $em->flush();
        return $this->redirect($this->generateUrl('user_list'));
    }
}
