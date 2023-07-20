<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Images;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Image;

class ArticlesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',options:[
                'label' => 'Nom'
            ])
            ->add('price', MoneyType::class,options:[
                'label' => 'Prix',
                'divisor' => 100,
                'constraints' => [
                    new Positive(
                        message: 'Le prix ne peut être négatif',
                    )
                ]
            ])
            ->add('description')
            ->add('stock',options:[
                'label' => 'Unités en stock'
            ])

            //->add('article_picture',options:[
            //    'label' => 'Chemin de la photo])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label'=> 'name',
                'label' => 'Catégorie',
                'group_by' => 'parent.name',
                'query_builder' => function(CategoryRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                        ->where('c.parent IS NOT NULL')
                        ->orderBy('c.name','ASC');
                }
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new Image([
                            'maxWidth' => 2200,
                            'maxWidthMessage' => 'L\'image doit faire {{ max_width }} pixels de large au maximum',
                        ]),
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
