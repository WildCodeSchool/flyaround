<?php

/**
 * PlaneModelType form file
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
 * PlaneModelType form type.
 *
 * @category FormType
 * @package  FormType
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class PlaneModelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model')
            ->add('manufacturer')
            ->add('cruiseSpeed')
            ->add('planeNbSeats')
            ->add('isAvailable');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'AppBundle\Entity\PlaneModel'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_planemodel';
    }
}
