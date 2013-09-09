<?php

namespace Hexmedia\ContentBundle\Form\Type\Area;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddType extends AbstractType
{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function doBuildForm(FormBuilderInterface $builder, array $options)
	{
	}

    /**
     * @return string
     */
    public function getName()
    {
        return 'hexmedia_contentbundle_area_add';
    }
}
