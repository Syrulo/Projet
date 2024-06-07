<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Producteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du produit',
                'required' => true
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix du produit',
                'divisor' => 100,
                'required' => true
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Image'
                
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
            ])
            ->add('producteur', EntityType::class, [
                'class' => Producteur::class,
                'label' => 'Producteur',
                'choice_label' => 'nom',
            ])
            ->add('Enregistrer', SubmitType::class,[
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
