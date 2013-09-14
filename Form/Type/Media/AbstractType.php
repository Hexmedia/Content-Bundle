<?php

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Hexmedia\ContentBundle\Form\Type\AbstractType as AbstractTypeBase;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractType extends AbstractTypeBase
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addButtons($builder);

        $builder
            ->add(
                'name',
                'text',
                [
                    'label' => 'Name',
                    'required' => false
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'label' => 'Description',
                    'required' => false
                ]
            );

        $this->doBuildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Hexmedia\ContentBundle\Entity\Media'
            )
        );
    }

}
