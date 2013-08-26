<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AreaAddType extends AreaAbstractType
{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'hexmedia_contentbundle_area_add';
	}

}
