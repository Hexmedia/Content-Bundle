<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType as AbstractTypeBase;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractType extends AbstractTypeBase
{
    abstract protected function doBuildForm(FormBuilderInterface $builder, array $options);

    protected function addButtons(FormBuilderInterface $builder)
    {
        $builder
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
    }

    protected function addPublished(FormBuilderInterface $builder)
    {
        $builder
            ->add(
                'publish',
                'submit',
                [
                    'label' => 'Save & Publish',
                    'attr' => [
                        'class' => 'btn-primary',
                        'data-loading-text' => 'Saving and publishing ...'
                    ]
                ]
            )
            ->add(
                'published',
                'publication'
            )
            ->add(
                'publishedFrom',
                'datepicker',
                [
                    'label' => 'From:',
                ]
            )
            ->add(
                'publishedTo',
                'datepicker',
                [
                    'label' => 'To:',
                ]
            );
    }

    protected function addSeo(FormBuilderInterface $builder)
    {

        $builder
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
            );
    }

    protected function addDeleteButton(FormBuilderInterface $builder)
    {
        $builder
            ->add(
                'delete',
                'submit',
                [
                    'label' => 'Delete',
                    'attr' => [
                        'class' => "btn-danger"
                    ]
                ]
            );
    }
}
