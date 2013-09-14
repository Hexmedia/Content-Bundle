<?php

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{

    public function doBuildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addDeleteButton($builder);
    }

    public function getName()
    {
        return 'hexmedia_content_mediatype_edit';
    }

}
