<?php

namespace Hexmedia\ContentBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AreaEditType extends AreaAbstractType
{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function doBuildForm(FormBuilderInterface $builder, array $options)
	{
        $builder->add('delete', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => "btn-danger"
                )
            ));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'hexmedia_contentbundle_area_edit';
	}

}
