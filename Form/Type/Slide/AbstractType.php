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
            ->add('published')
            ->add('publishedFrom')
            ->add('publishedTo')
            ->add('sort')
        ;

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
