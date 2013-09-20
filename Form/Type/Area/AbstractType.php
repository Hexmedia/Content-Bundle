<?php

namespace Hexmedia\ContentBundle\Form\Type\Area;

use Hexmedia\AdministratorBundle\Form\Type\CrudType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractType extends CrudType
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
                    'required' => false,
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
