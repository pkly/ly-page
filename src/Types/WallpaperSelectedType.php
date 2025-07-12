<?php

declare(strict_types=1);

namespace App\Types;

use App\Entity\Media\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class WallpaperSelectedType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add('tags', EntityType::class, [
            'multiple' => true,
            'class' => Tag::class,
            'attr' => [
                'class' => 'form-select',
            ],
        ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }
}
