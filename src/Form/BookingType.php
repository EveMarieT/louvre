<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOfVisit', DateType::class, [
                'label' => 'Date de visite',
                'widget' => 'single_text'
            ])
            ->add('period', ChoiceType::class, [
                'label' => 'Type de billet',
                'choices' => array(
                    Booking::TYPE_LABEL_DAY => Booking::TYPE_DAY,
                    Booking::TYPE_LABEL_HALF_DAY => Booking::TYPE_HALF_DAY,
                ),
                'expanded' => true,
            ])
            ->add('numberOfPeople', IntegerType::class, [
                'label' => 'Nombre de personne',
                'attr' => ['max' => Booking::MAX_NB_TICKETS,
                            'min' => Booking::MIN_NB_TICKETS]
            ])
            ->add('email', EmailType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}