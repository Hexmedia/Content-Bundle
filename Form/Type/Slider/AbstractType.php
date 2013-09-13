<?php

namespace Hexmedia\ContentBundle\Form\Type\Slider;

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
        $builder->add('name');
        $this->addButtons($builder);

        $this->doBuildForm($builder, $options);
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
