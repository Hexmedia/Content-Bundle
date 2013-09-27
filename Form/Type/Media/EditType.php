<?php

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addDeleteButton($builder);
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'hexmedia_media_edit';
    }

}
