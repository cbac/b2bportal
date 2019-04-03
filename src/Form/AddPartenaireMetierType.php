<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Metier;
use App\Entity\PartenaireMetier;

class AddPartenaireMetierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomMetier', EntityType::class, [
            // looks for choice from this entity
            'class' => Metier::class,
            // uses the nom property as the visible option string
            'choice_label' => 'nom'
        ]);
    }
    /**
     * Attention : le formulaire présente une liste de noms de métiers à partir de la classe
     * Metier. Le type de formulaire associé provient de la classe PartenaireMetier qui 
     * représente les associations NxN entre la classe Partenaire et la classe Metier.
     * Pour que la liaison se passe correctement il faut ajouter à la classe PartenaireMetier
     * des méthodes qui permettent de faire la correspondance entre le nom de metier et le metier.
     * Voir classe PartenaireMetier
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PartenaireMetier::class,
        ]);
    }

}
