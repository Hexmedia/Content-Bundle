<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AreaAbstractType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content', 'textarea')
            ->add(
                'global',
                'checkbox',
                [
                    'label' => 'Global'
                ]
            )
            ->add(
                'save',
                "submit",
                [
                    'label' => "Save",
                    'attr' => [
                        'class' => 'btn-success',
                        'data-loading-text' => 'Saving ... '
                    ]
                ]
            )
            ->add(
                'saveAndExit',
                "submit",
                [
                    'label' => "Save & Exit",
                    'attr' => [
                        'class' => 'btn-success',
                        'data-loading-text' => 'Saving ... '
                    ]
                ]
            );

        $this->doBuildForm($builder, $options);
	}

    abstract protected function doBuildForm(FormBuilderInterface $buildier, array $options);

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Hexmedia\ContentBundle\Entity\Area'
            )
        );
    }

}
