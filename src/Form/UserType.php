<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                'label' => 'Jméno:'
            ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Zadaná hesla se neshodují',
                'first_options'  => ['label' => 'Heslo'],
                'second_options' => ['label' => 'Heslo znovu']
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email:',
                'required' => true,
            ])
            ->add('role', ChoiceType::class,[
                'label' => 'Oprávnění',
                'placeholder' => 'Typ oprávnění',
                'mapped' => true,
                'required' => true,
                'choices'  => [
                    'Uživatel' => "ROLE_USER",
                    'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('save',SubmitType::class,[
                'label' => 'Uložit'
            ])
        ;
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
