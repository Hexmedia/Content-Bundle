<?php

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('file', 'file', array(
					'label' => 'File',
					'required' => true
		));

        parent::buildForm($builder, $options);

        $this->addAddNextButton($builder);
	}

    public function getName()
    {
        return 'hexmedia_media_add';
    }

}
