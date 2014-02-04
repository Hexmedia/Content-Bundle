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

        $builder
            ->add('translations', 'a2lix_translations', [
                    'fields' => [
                        'title' => [
                            'field_type' => 'text',
                            'attr' => [
                                'placeholder' => 'Title',
                                'class' => 'element-title'
                            ]
                        ],
                        'teaser' => [
                            'field_type' => 'raptor',
                            'attr' => [
                                'class' => 'small-raptor'
                            ]
                        ],
                        'content' => [
                            'field_type' => 'raptor',
                            'attr' => [
                                'class' => 'textarea-content'
                            ]
                        ]
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
