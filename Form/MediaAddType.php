<?php

namespace Hexmedia\ContentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class MediaAddType extends MediaTypeAbstract {

	public function doBuild(FormBuilderInterface $builder, array $options) {
		$builder
			->add('file', 'file', array(
				'label' => 'File',
				'required' => true
		));
	}

}
