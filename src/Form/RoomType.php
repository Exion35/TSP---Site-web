<?php

namespace App\Form;

use App\Entity\Owner;
use App\Entity\Room;
use Proxies\__CG__\App\Entity\Owner as EntityOwner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('summary')
            ->add('description')
            ->add('capacity')
            ->add('superficy')
            ->add('price')
            ->add('address')
            ->add('rating')
            ->add('regions')
            ->add('onSale')
            ->add('isFree')
            ->add('imageName', TextType::class,  ['disabled' => true])
            ->add('imageFile', VichImageType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
