<?php

namespace App\Form;

use App\Entity\Argument;
use App\Entity\Policy;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PolicyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent')
            ->add('title')
            ->add('text')
            ->add('source')
            ->add('policyTheme')
            ->add('argument', EntityType::class, array(
                'class' => Argument::class,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('a')
                        // find all users where 'deleted' is NOT '1'
                        ->andWhere('a.parent is NULL');
                },
            ))
            ->add('language')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Policy::class,
        ]);
    }
}
