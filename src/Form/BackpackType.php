<?php

namespace App\Form;

use App\Entity\Backpack;
use App\Form\BackpackItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BackpackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('publishedDate')
            ->add('users') 
            ->add('trip')
            ->add('country')
        ;
         // formulaire imbriqué pour ajouter des items
         $builder->add('backpackitem', CollectionType::class, [
                
            'entry_type'   => BackpackItemType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'label' => ' ',
           
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Backpack::class,
        ]);
    }
}
