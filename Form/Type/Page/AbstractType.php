<?php

namespace Hexmedia\ContentBundle\Form\Type\Page;

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

        parent::buildForm($builder, $options);
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
