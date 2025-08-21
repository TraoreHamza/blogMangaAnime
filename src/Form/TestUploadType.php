<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageFile', FileType::class, [
            'label' => 'Choisissez une image',
            'mapped' => false,  // important : le champ ne correspond pas directement à une entité
            'required' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {}
}
