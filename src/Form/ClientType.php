<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Localisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('user',UserType::class)
            ->add('localisation', EntityType::class, [
                // looks for choice from this entity
                'class' => Localisation::class,
                // uses the nom property as the visible option string
                'label' => 'adresse', 'required'=>false
            ])
            ->add('new_address', LocalisationType::class, ['label'=>'Nouvelle Adresse',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
