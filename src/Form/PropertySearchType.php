<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, ['required' => false, 'label' => false, 'attr'=> ['placeholder' => 'Budget Maximal']])
            ->add('minSurface', IntegerType::class, ['required' => false, 'label' => false, 'attr'=> ['placeholder' => 'Surface minimale']])
            ->add('options', EntityType::class, ['required' => false, 'label' => false, 'class'=> Option::class,'choice_label' => 'name', 'multiple' => true])
           // ->add('Submit', SubmitType::class, ['label' => 'Rechercher'])  //probleme de valeur affichée dans l'url
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',  //Y- Method Post par defaut
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()  //Y Pour Changer le nom des champs dans l'URL
    {
        // return parent::getBlockPrefix();
        return '';
    }
}
