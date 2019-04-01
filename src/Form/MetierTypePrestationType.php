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
    /**
     * Attention : le formulaire présente une liste de noms de TypePrestation à partir de la classe
     * TypePrestation. Le type de formulaire associé provient de la classe MetierTypePrestation qui
     * représente les associations NxN entre la classe TypePrestation et la classe Metier.
     * Pour que la liaison se passe correctement il faut ajouter à la classe MetierTypePrestation
     * des méthodes qui permettent de faire la correspondance entre le nom de TypePrestation et le type de prestation.
     * Voir classe MetierTypePrestation
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MetierTypePrestation::class,
        ]);
    }
}
