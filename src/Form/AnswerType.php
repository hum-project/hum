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
            ->add('text', TextType::class)
            ->add('scale', IntegerType::class)
            ->add('language', EntityType::class, array(
                'class' => Language::class,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('l');
                },
            ))
            ->add('minimum', IntegerType::class)
            ->add('maximum', IntegerType::class)
        ;
    }

}
