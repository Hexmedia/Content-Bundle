<?php

namespace Hexmedia\ContentBundle\Form\Fields;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaType extends ChoiceType
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $entityManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->setAttribute("preview", $options['preview']);
        $builder->setAttribute("media_type", $options['media_type']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $vars = [
            'preview' => $options['preview'],
            'media_type' => $options['media_type'],
            'select_label' => isset($options['select_label']) ? $options['select_label'] : "Select Media",
            'change_label' => isset($options['change_label']) ? $options['change_label'] : "Change Media"
        ];

        if ($vars['preview'] && $form->getViewData()) {
            $repository = $this->entityManager->getRepository("HexmediaContentBundle:Media");

            $entity = $repository->find($form->getViewData());

            $vars['entity'] = $entity;
        }

        $view->vars = array_replace(
            $view->vars,
            $vars
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(
                [
                    'preview',
                    'media_type',
                    'select_label',
                    'change_label'
                ]
            )
            ->addAllowedTypes(
                [
                    'preview' => 'string',
                    'media_type' => 'string',
                    'select_label' => 'string',
                    'change_label' => 'string'
                ]
            );

        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(
            [
                'class' => 'Hexmedia\ContentBundle\Entity\Media'
            ]
        );
    }

    public function getParent()
    {
        return "entity";
    }

    public function getName()
    {
        return "media";
    }

    /**
     * Return the default loader object.
     *
     * @param ObjectManager $manager
     * @param mixed $queryBuilder
     * @param string $class
     *
     * @return EntityLoaderInterface
     */
    public function getLoader(ObjectManager $manager, $queryBuilder, $class)
    {
        // TODO: Implement getLoader() method.
    }
}