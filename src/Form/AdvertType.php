<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Categorie;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',textType::class,["label" =>"Nom du produit", "attr" => [ "class" =>"pouf"]])
            ->add('Description',textAreaType::class)
            ->add('Devise',ChoiceType::class,['choices'  => [
                'USD' => 'USD',
                'EUR' => 'EUR',
            ]])
            ->add('Prix',textType::class,["label" =>"votre prix", "attr" => [ "class" =>"pouf"]])
            ->add('Autre',textType::class,["label" =>"Autre information ", "attr" => [ "class" =>"pouf"]])
            ->add('Image',FileType::class, ['label' => 'Deposer une image '])
            ->add('Region',EntityType::class,['multiple' =>false, 'expanded' =>false, 'class'=> Region::class ])
            ->add('Categorie',EntityType::class,['multiple' =>false, 'expanded' =>false, 'class'=> Categorie::class ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }

}
