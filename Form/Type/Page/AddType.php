<?php

namespace Hexmedia\ContentBundle\Form\Type\Page;

use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "content_page_type_add";
    }

    protected function doBuildForm(FormBuilderInterface $buildier, array $options)
    {
    }
}