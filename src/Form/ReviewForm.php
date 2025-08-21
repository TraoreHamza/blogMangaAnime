<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReviewForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de la review',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le contenu ne peut pas être vide']),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm',
                    'rows' => 5,
                ],
            ])
            ->add('rating', IntegerType::class, [
                'label' => 'Note (entre 1 et 5)',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La note est obligatoire']),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => 'La note doit être au minimum {{ limit }}',
                        'notInRangeMessage' => 'La note ne peut pas dépasser {{ limit }}',
                    ]),
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'class' => 'form-input rounded-md border-gray-300',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Publié' => 'published',
                    'Brouillon' => 'draft',
                    'Archivé' => 'archived',
                ],
                'required' => true,
                'placeholder' => 'Choisissez un statut',
                'attr' => [
                    'class' => 'form-select rounded-md border-gray-300',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
