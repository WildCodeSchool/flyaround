<?php

/**
 * RegistrationType form file
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

/**
 * RegistrationType form type.
 *
 * @category FormType
 * @package  FormType
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('birthDate')
            ->add('isACertifiedPilot');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
