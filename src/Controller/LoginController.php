<?php

namespace App\Controller;

use App\Form\ForgetPasswordType;
use App\Form\LoginType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
class LoginController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
      
        $authUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('login/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    /**
     * @Route("/forgetpassword", name="user_forget_password")
     */
    
    public function forgetPassword(Request $request){
        
        $form = $this->createForm(ForgetPasswordType::class);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
              $email =  $form["email"]->getData();
              $repository = $this->getDoctrine()->getRepository(User::class);
              $searchuser = $repository->findOneBy(['email' =>$email]);
              if(null !== $searchuser){
                  return $this->render(
                      'login/forgetpasswordsend.html.twig',
                      array('form' => $form->createView())
                      );
              }else{
                  
              }
              
        }
        return $this->render(
            'login/forgetpassword.html.twig',
            array('form' => $form->createView())
            );
    }
    
    /**
     * @Route("/forgetpasswordsend", name="user_forget_password_send")
     */
    
    public function forgetPasswordSend(Request $request){
        $user = new User();
        
        $form = $this->createFormBuilder()
        ->add('email', EmailType::class)
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $user->getEmail();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $searchuser = $repository->findOneBy(['email' => $user->getEmail()]);
            
            
            $response = new RedirectResponse('/task/success');
            $response->prepare($request);
            
            return $response->send();
        }
        
        return $this->render('login/forgetpasswordsend.html.twig', array(
            'isim' => 'murat',
            'soyisim'=> 'cicek'
            
        ));
    }
    
}
