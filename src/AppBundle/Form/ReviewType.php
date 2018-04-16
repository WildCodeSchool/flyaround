<?php

/**
 * ReviewType form file
 *
 * PHP Version 7.1
 *
 * @category Form
 * @package  Form
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

/**
 * ReviewType form type.
 *
 * @category FormType
 * @package  FormType
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class ReviewType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, array('attr' => array('maxlength' => 250, 'label' => 'Description')))
            ->add('publicationDate', DateType::class, array('data' => new \DateTime('now')))
            ->add('note', IntegerType::class,  array('attr' => array('min' => 0, 'max' => 5, 'label' => 'Note')))
            ->add('agreeTerms', CheckboxType::class, array('mapped' => false))
            ->add(
                'userRated',   EntityType::class, array(
                'class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => 'lastName')
            )
            ->add('reviewAuthor');
    }

    /**
     * {@inheritdoc} Targeting Review entity
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Review'
            )
        );
    }

    /**
     * {@inheritdoc} getName() is deprecated
     */
    public function getBlockPrefix()
    {
        return 'appbundle_review';
    }
}