<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chef;
use App\Entity\User;
use App\Entity\Plat;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/authentification", name="authentification")
     */
    public function index(): Response
    {
        return $this->render('authentification/index.html.twig', [
            'controller_name' => 'AuthentificationController',
        ]);
    }
     //pour faire l'inscription d'un nouveau freelancer
    /**
    * @route("/register" , name="register")
    */
   public function register (Request $request,UserPasswordEncoderInterface $passwordEncoder )
   {
        if($request->isMethod('POST'))
        {   
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $image = $request->request->get('image');
        $username = $request->request->get('username');
        $mdp = $request->request->get('mdp');
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setImage($image);
        $user->setUsername($username);   
        $password = $passwordEncoder->encodePassword($user, $mdp);
        $user->setPassword($password);
        $em->persist($user);  
        $em->flush();
        return $this->redirectToRoute("repas_index");
        }
        return $this->render('register/register.html.twig');
   }
  //pour afficher la page de l'inscription
    /**
    * @route("/aff_register" , name="aff_register")
    */
    public function aff_register ()
    {
         return $this->render('register/register.html.twig', [
         'identifiant' => '$listetache',
     ]);}
 
 
    //pour connecter
    /**
    * @Route("/", name="login")
    */

    public function login(AuthenticationUtils $authenticationUtils)
    {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername= $authenticationUtils->getLastUsername();

    return $this->render('login/login.html.twig', [
    'last_username' =>$lastUsername,
    'error'         =>$error,
    ],);
    }


    //pour faire le logout
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    return $this->redirectToRoute("login");

    throw new \Exception('this should not be reached!');
    }

}
