<?php

namespace App\Form;

use App\Entity\Outils;
use App\Entity\Tag;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OutilsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('slug')
            ->add('toolUrl')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Choose Image',
                'required' => false, // Mettre à true si l'image est obligatoire
                'allow_delete' => true, // Permet de supprimer l'image existante
                'download_uri' => false, // Afficher un lien pour télécharger l'image existante
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => true, // ou false selon le rendu souhaité
                'choice_label' => 'name', // Utiliser la propriété 'name' de l'entité Tag pour l'affichage
                // Autres options si nécessaire
            ])
            ->add('description')
            ->add('brouillon');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Outils::class,
        ]);
    }
}
