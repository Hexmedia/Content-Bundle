<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 06.09.13
 * Time: 12:43
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\Form\Type;


use Hexmedia\ContentBundle\Form\Type\PageTypeAbstract;
use Symfony\Component\Form\FormBuilderInterface;

class PageTypeEdit extends PageTypeAbstract {

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "content_page_type_edit";
    }

    protected function doBuildForm(FormBuilderInterface $buildier, array $options)
    {
    }
}