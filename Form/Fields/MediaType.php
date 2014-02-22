<?php

namespace Hexmedia\ContentBundle\Form\Fields;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\Options;

class MediaType extends AbstractType
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

        if ($options['multiple']) {
            $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $i = 0;

                $data = $event->getData();

//                foreach ($data->toArray() as $element) {
//                    $form->add($i, 'hidden', [
//                        'data' => $element->getId(),
//                        'property_path' => null
//                    ]);
//                }
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $vars = [
            'preview' => $options['preview'],
            'compound' => true,
            'media_type' => $options['media_type'],
            'select_label' => isset($options['select_label']) ? $options['select_label'] : "Select Media",
            'change_label' => isset($options['change_label']) ? $options['change_label'] : "Change Media",
            'select_multiple_label' => isset($options['select_multiple_label']) ? $options['select_multiple_label'] : "Select Media",
            'change_multiple_label' => isset($options['change_multiple_label']) ? $options['change_multiple_label'] : "Change Media",
        ];

        if ($vars['preview'] && $form->getViewData()) {
            $repository = $this->entityManager->getRepository("HexmediaContentBundle:Media");

            if ($options['multiple'] == true) {
                $entities = $repository->findInBy(['id' => $form->getViewData()]);
                $vars['entities'] = $entities;
            } else {
                $entity = $repository->find($form->getViewData());
                $vars['entity'] = $entity;
            }
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
                    'change_label',
                    'select_multiple_label',
                    'change_multiple_label'
                ]
            )
            ->addAllowedTypes(
                [
                    'preview' => 'string',
                    'media_type' => 'string',
                    'select_label' => 'string',
                    'change_label' => 'string',
                    'select_multiple_label' => 'string',
                    'change_multiple_label' => 'string'
                ]
            );

        parent::setDefaultOptions($resolver);


        $compound = function (Options $options) {
            return $options['multiple'];
        };

        $resolver->setDefaults(
            [
                'class' => 'Hexmedia\ContentBundle\Entity\Media',
                'compound' => $compound
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
}