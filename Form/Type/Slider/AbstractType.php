<?php

namespace Hexmedia\ContentBundle\Form\Type\Slider;

use Symfony\Component\Form\AbstractType as AbstractTypeBase;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractType extends AbstractTypeBase
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('published', 'choice', [
                'choices' => [
                    false => 'No',
                    true => 'Yes'
                ]
            ])
            ->add('publishedFrom',
                'date',
                [
                    'label' => 'Published From:',
                    'required' => false,
                    'render_optional_text' => false,
                    'widget' => 'single_text',
                    'widget_addon' => [
                        'type' => 'prepend',
                        'text' => '<span class="icon-calendar"></span>'
                    ]
                ])
            ->add('publishedTo',
                'date',
                [
                    'label' => 'Published To:',
                    'required' => false,
                    'render_optional_text' => false,
                    'widget' => 'single_text',
                    'widget_addon' => [
                        'type' => 'prepend',
                        'text' => '<span class="icon-calendar"></span>'
                    ]
                ])
            ->add('sort', 'number')
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
            );;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hexmedia\ContentBundle\Entity\Slider'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hexmedia_contentbundle_slider';
    }
}
