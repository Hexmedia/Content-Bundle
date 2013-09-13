<?php

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{

	public function doBuildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('file', 'file', array(
					'label' => 'File',
					'required' => true
		));
	}

    public function getName()
    {
        return 'hexmedia_mediabundle_mediatype_add';
    }

}