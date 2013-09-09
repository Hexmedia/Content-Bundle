<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 06.09.13
 * Time: 12:43
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\Form\Type\Page;


use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "content_page_type_edit";
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'delete',
            'submit',
            [
                'label' => 'Delete',
                'attr' => [
                    'class' => "btn-danger"
                ]
            ]
        );
    }
}