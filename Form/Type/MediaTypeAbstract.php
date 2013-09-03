<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class MediaTypeAbstract extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            )
            ->add(
                'save',
                'submit',
                [
                    'label' => 'Save',
                    'attr' => [
                        'class' => 'btn-primary',
                        'data-loading-text' => 'Saving ...'
                    ]
                ]
            )
            ->add(
                'saveAndExit',
                'submit',
                [
                    'label' => 'Save & Exit',
                    'attr' => [
                        'class' => 'btn-primary',
                        'data-loading-text' => 'Saving ...'
                    ]
                ]
            );

        $this->doBuildForm($builder, $options);
    }

    abstract protected function doBuildForm(FormBuilderInterface $buildier, array $options);

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Hexmedia\ContentBundle\Entity\Media'
            )
        );
    }

}
