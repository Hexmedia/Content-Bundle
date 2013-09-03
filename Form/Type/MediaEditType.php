<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class MediaEditType extends MediaTypeAbstract
{

	public function doBuildForm(FormBuilderInterface $builder, array $options)
	{
        $builder->add('delete', 'submit', array(
                    'label' => 'Delete'
                ));
	}

    public function getName()
    {
        return 'hexmedia_mediabundle_mediatype_edit';
    }

}
