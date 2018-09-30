<?php

namespace App\Form;

use App\Entity\Pack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'));

        $builder->add('prenom', TextType::class, array('label' => 'Prenom', 'translation_domain' => 'FOSUserBundle'));

        $builder->add('couleur', TextType::class, array('label' => 'couleur', 'translation_domain' => 'FOSUserBundle'));
        $builder->add('famille', TextType::class, array('label' => 'famille', 'translation_domain' => 'FOSUserBundle'));
        $builder->add('nouriture', TextType::class, array('label' => 'nouriture', 'translation_domain' => 'FOSUserBundle'));
        $builder->add('date', DateType::class, [
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'label' => 'Date Naissance',
            'attr' => [

                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pack::class,
        ]);
    }
}
