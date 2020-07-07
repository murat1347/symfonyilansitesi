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

class AccountController extends Controller
{
    /**
     * @Route("/account", name="account")
     */
    public function account()
    {
        return $this->render('panel/account.html.twig');
        
    }
}
