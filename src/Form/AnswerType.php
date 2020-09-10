<?php

namespace App\Form;

use App\Entity\Language;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Nominal' => true,
                    'Ordinal' => false,
                    'Continuous' => false
                ]
            ])
            ->add('text', TextType::class, [
                "required" => false
            ])
            ->add('scale', IntegerType::class, [
                "required" => false
            ])
            ->add('minimum', IntegerType::class, [
                "required" => false
            ])
            ->add('maximum', IntegerType::class, [
                "required" => false
            ])
        ;
    }

}
