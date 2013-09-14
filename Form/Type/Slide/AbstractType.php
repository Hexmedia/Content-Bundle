<?php

namespace Hexmedia\ContentBundle\Form\Type\Slide;

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
        $this->addPublished($builder);
        $this->addButtons($builder);

        $builder
            ->add('sort')
            ->add('subtitle', 'text')
            ->add('description', 'textarea')
            ->add('bgImage', 'media', [
                    'media_type' => 'image',
                    'preview' => 'big_admin_square'
                ])
//            ->add('bgImage')
            ->add('link', 'text')
            ->add(
                'title',
                'text',
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Enter title here'
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
                'data_class' => 'Hexmedia\ContentBundle\Entity\Slide'
            )
        );
    }
}
