<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Metier;
use Doctrine\ORM\EntityRepository;

class AddMetierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', EntityType::class, [
            // looks for choice from this entity
            'class' => Metier::class,
            // uses the nom property as the visible option string
            'choice_label' => 'nom',
            // used to render a select box, check boxes or radios
            //'multiple' => true,
            // 'expanded' => true,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Metier::class,
        ]);
    }

}
