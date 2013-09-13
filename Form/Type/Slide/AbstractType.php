<?php

namespace Hexmedia\ContentBundle\Form\Type\Slide;

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
            );

        $this->doBuildForm($builder, $options);
    }

    abstract protected function doBuildForm(FormBuilderInterface $builder, array $options);

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hexmedia\ContentBundle\Entity\Slide'
        ));
    }
}
