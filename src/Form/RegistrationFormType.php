<?php
//REGISTRAČNÍ FORMULÁŘ v Symfony Forms
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email') //Vstupní pole pro email
            ->add('Firstname') //Vstupní pole pro jméno
            ->add('Lastname') // Vstupní pole pro příjmení
                //zaškrtávaví políčko pro potvrzení zadaných údaju
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false, 
                'constraints' => [
                    new IsTrue([
                        //V případě, že jsme nazaškrtli vypíše se hláška
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            //Vstupní pole pro Heslo
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
