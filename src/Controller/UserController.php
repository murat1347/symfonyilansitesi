<?php
namespace App\Controller;

use App\Form\EmailChangeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserController extends Controller
{

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [
            'path' => str_replace($this->getParameter('kernel.project_dir') . '/', '', __FILE__)
        ]);
    }

    /**
     * @Route("/security_logout", name="security_logout")
     */
    public function accountLogout(Request $request)
    {
        $this->container->get('session')->clear();
        $this->container->get('session')->invalidate();
       
        echo "<meta http-equiv='refresh' content='0; url=/' />";
        die();
        //$this->container->set('');
     //   return $this->redirectToRoute('panel_account');
    }

    /**
     * @Route("/panel/account", name="panel_account")
     */
    public function account()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [
            'path' => str_replace($this->getParameter('kernel.project_dir') . '/', '', __FILE__)
        ]);
    }

    /**
     * @Route("/panel/account/emailchange", name="panel_account_email_change")
     */
    public function emailChange(Request $request)
    {
        $form = $this->createForm(EmailChangeType::class);
        $form->handleRequest($request);
        $newemail = $form["newemail"]->getData();
        $oldmail = $this->getUser('$email');
        if ($newemail != null) {
            $id = $this->getUser()->getId();
            $user_repository = $this->getDoctrine()->getRepository(User::class);
            $em = $this->getDoctrine()->getManager();
            
            $user = $user_repository->find($id);
            $user->setEmail($newemail);
            $em->flush();
        }
        
        return $this->render('panel/account/emailchange.html.twig', array(
            'form' => $form->createView(),
            'usermail' => $oldmail
        ));
    }

    /**
     * @Route("/panel/account/passwordchange", name="panel_account_password_change")
     */
    public function changepasswordAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $session = $request->getSession();
        
        if ($request->getMethod() == 'POST') {
            $old_pwd = $request->get('old_pass');
            $new_pwd = $request->get('new_pass');
            
            $user = $this->getUser();
            
            $new_pwd_encoded = $encoder->encodePassword($user, $new_pwd);
            $user->setPassword($new_pwd_encoded);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            
            $manager->flush();
            $session->getFlashBag()->set('success_msg', "Password change successfully!");
            return $this->render('panel/account/passwordchange.html.twig');
        }
        
        return $this->render('panel/account/passwordchange.html.twig', array());
    }
}
    
