<?php

namespace Hexmedia\ContentBundle\Form\Type\Page;

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
            ->add(
                'title',
                'text',
                [
                    'attr' => [
                        'placeholder' => "Title",
                        'class' => 'element-title'
                    ]
                ]
            )
            ->add(
                'teaser',
                'textarea',
                [
                    'attr' => [
                        'class' => 'small-raptor'
                    ]
                ]
            )
            ->add(
                'content',
                'textarea',
                [
                    'attr' => [
                        'class' => 'textarea-content'
                    ]
                ]
            )
            ->add(
                'seoTitle',
                null,
                [
                    'label' => 'Title',
                    'render_optional_text' => false
                ]
            )
            ->add(
                'seoKeywords',
                null,
                [
                    'label' => 'Keywords',
                    'render_optional_text' => false
                ]
            )
            ->add(
                'seoDescription',
                'textarea',
                [
                    'required' => false,
                    'label' => 'Description',
                    'render_optional_text' => false,
                    'attr' => [
                        'class' => 'no-raptor'
                    ]
                ]
            )
            ->add(
                'published',
                'choice',
                [
                    'choices' => [
                        false => 'No',
                        true => 'Yes'
                    ]
                ]
            )
            ->add(
                'publishedFrom',
                'date',
                [
                    'label' => 'From:',
                    'required' => false,
                    'render_optional_text' => false,
                    'widget' => 'single_text',
                    'widget_addon' => [
                        'type' => 'prepend',
                        'text' => '<span class="icon-calendar"></span>'
                    ]
                ]
            )
            ->add(
                'publishedTo',
                'date',
                [
                    'label' => 'To:',
                    'required' => false,
                    'render_optional_text' => false,
                    'widget' => 'single_text',
                    'widget_addon' => [
                        'type' => 'prepend',
                        'text' => '<span class="icon-calendar"></span>'
                    ]
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
            );//            ->add('admin')
//            ->add('media')
//            ->add('categories')
        ;

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
                'data_class' => 'Hexmedia\ContentBundle\Entity\Page'
            )
        );
    }
}
