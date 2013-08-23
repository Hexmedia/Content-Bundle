<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class MediaTypeAbstract extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('name', 'text', array(
					'label' => 'Name',
					'required' => false
				))
				->add('description', 'textarea', array(
					'label' => 'Description',
					'required' => false
				))
				->add('save', 'submit', array(
					'label' => 'Save'
				))
		;

		$this->doBuild($builder, $options);
	}

	abstract protected function doBuild(FormBuilderInterface $buildier, array $options);

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Hexmedia\ContentBundle\Entity\Media'
		));
	}

	public function getName()
	{
		return 'hexmedia_mediabundle_mediatype';
	}

}
