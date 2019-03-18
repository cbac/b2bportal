<?php

namespace App\Form;

use App\Entity\MetierTypePrestation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\TypePrestation;

class MetierTypePrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomType', EntityType::class, [
            // looks for choices from this entity
            'class' => TypePrestation::class,
            // uses the nomType property as the visible option string
            'choice_label' => 'nomType',
            // used to render a select box, check boxes or radios
            //'multiple' => true,
            // 'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MetierTypePrestation::class,
        ]);
    }
}
