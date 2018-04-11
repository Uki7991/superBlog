<?php

namespace PostBundle\Form;

use PostBundle\Entity\Category;
use PostBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('image', null, [
                'data_class' => null
            ])
            ->add('blockquote', TextareaType::class, [
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
            ])
            ->add('tags')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => 'Select a category...',
                'query_builder' => function(CategoryRepository $repository) {
                    return $repository->getParentCats();
                },
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PostBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'postbundle_post';
    }


}
