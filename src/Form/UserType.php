<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('email')
            ->add('roles')
            ->add('password')
            ->add('firstname')
            ->add('Enable')
            ->add('Region')*/
            ->add('Username',textType::class,["label" =>"votre nom"])
            ->add('Password',PasswordType::class,["label" =>"Mot de passe "])
            ->add('firstname',textType::class,["label" =>"votre Prenom"])
            ->add('email',EmailType::class,["label" =>"votre mail", "attr" => [ "class" =>"pouf"]])
            //   ->add('Enable')
            //  ->add('Role')
            ->add('Region',EntityType::class,['multiple' =>false, 'expanded' =>false, 'class'=> Region::class ])
        ;

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
