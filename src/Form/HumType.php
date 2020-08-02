<?php

namespace App\Form;

use App\Entity\Hum;
use App\Entity\Institution;
use App\Entity\Policy;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')

            // Solution found at https://stackoverflow.com/questions/23721670/symfony2-how-to-filter-the-options-of-an-entity-choice-form-field-by-a-certain
            // Credit to alias Nicolai Fröhlich (StackOverflow 2014-05-18) [Fetched 2020-08-02]
            ->add('policy', EntityType::class, array(
                'class' => Policy::class,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('p')
                        // find all users where 'deleted' is NOT '1'
                        ->where('p.parent is NULL');
                },
            ))
            ->add('institution', EntityType::class, array(
                'class' => Institution::class,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('i')
                        // find all users where 'deleted' is NOT '1'
                        ->where('i.translation is NULL');
                },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hum::class,
        ]);
    }
}
