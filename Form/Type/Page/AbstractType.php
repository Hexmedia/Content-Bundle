<?php

namespace Hexmedia\ContentBundle\Form\Type\Page;

use Hexmedia\ContentBundle\Form\Type\AbstractType as AbstractTypeBase;
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
        $this->addButtons($builder);
        $this->addPublished($builder);
        $this->addSeo($builder);

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
            );
            //            ->add('admin')
//            ->add('media')
//            ->add('categories')
        ;

        $this->doBuildForm($builder, $options);
    }

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
