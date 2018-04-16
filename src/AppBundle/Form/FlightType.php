<?php

/**
 * FlightType form file
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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * FlightType form type.
 *
 * @category FormType
 * @package  FormType
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class FlightType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure')
            ->add('arrival')
            ->add('nbFreeSeats')
            ->add('seatPrice')
            ->add('takeOffTime')
            ->add('publicationDate')
            ->add('description')
            ->add('plane')
            ->add('pilot')
            ->add('wasDone');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\Flight'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_flight';
    }
}
