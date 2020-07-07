<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class AddPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('pagename', TextType::class,array('label' => 'Sayfa İsmi') ) 
        ->add('pageimage', TextType::class,array('label' => 'Sayfa Resmi') )   
        ->add('pagelink', TextType::class,array('label' => 'Sayfa Linki') )      
        ->add('price', TextType::class,array('label' => 'Fiyat') )    
        ->add('description', TextType::class,array('label' => 'Açıklama') )   
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
   
    }
}
