<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 26.09.13
 * Time: 23:25
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\Form\Type\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('files', 'file', [
                'label' => 'File',
                'required' => true,
                'attr' => [
                    'style' => 'width: 200px;',
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                ]
            ]);
    }

    public function getName()
    {
        return 'hexmedia_upload';
    }
}