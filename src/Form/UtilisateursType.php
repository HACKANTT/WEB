<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                array(
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => 'Nom',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                'pattern' => '/^[a-zA-Z]+$/',
                                'message' => 'Le nom {{ value }} n\'est pas valide',
                            )
                        ),
                    )
                )
            )
            ->add(
                'mail',
                EmailType::class,
                array(
                    'label' => 'Mail',
                    'attr' => [
                        'placeholder' => 'Mail',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                'pattern' => '/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/',
                                'message' => 'L\'adresse mail {{ value }} n\'est pas valide',
                            )
                        ),
                    )
                )
            )
            ->add(
                'tel',
                TextType::class,
                array(
                    'label' => 'Téléphone (10 chiffres)',
                    'attr' => [
                        'placeholder' => 'Téléphone',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(

                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                #regex for french phone number (10 digits) or internationale (+336...)
                                'pattern' => '/^(\+33|0)[1-9](\d{2}){4}$/',
                                'message' => 'Le numéro de téléphone {{ value }}  n\'est pas valide',
                            ),
                        ),
                    )
                )
            )
            ->add(
                'prenom',
                TextType::class,
                array(
                    'label' => 'Prénom',
                    'attr' => [
                        'placeholder' => 'Prénom',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                'pattern' => '/^[a-zA-Z]+$/',
                                'message' => 'Le prénom {{ value }} n\'est pas valide',
                            )
                        ),
                    )
                )
            )
            ->add(
                'dateNaissance',
                BirthdayType::class,
                array(
                    'label' => 'Date de naissance :',
                    'widget' => 'choice',
                    'placeholder' => [
                        'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    ],
                )
            )
            ->add(
                'lienPortfolio',
                UrlType::class,
                array(
                    'help' => 'Le lien vers le portfolio doit être de la forme : http://www.monportfolio.com',
                    'label' => 'Lien vers votre portfolio',
                    'attr' => [
                        'placeholder' => 'Lien du Portfolio',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                'pattern' => '/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/.*)?$/i',
                                'message' => 'Le lien {{ value }} n\'est pas valide',
                            )
                        ),
                    )
                )
            )
            ->add(
                'login',
                TextType::class,
                array(
                    'label' => 'Nom d\'utilisateur',
                    'attr' => [
                        'placeholder' => 'Nom d\'utilisateur',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                'pattern' => '/^[a-zA-Z0-9]+$/',
                                'message' => 'Le login {{ value }} n\'est pas valide',
                            )
                        ),
                    )
                )
            )
            ->add(
                'password',
                PasswordType::class,
                array(
                    'help' => 'Le mot de passe doit contenir au moins 6 caractères, dont une majuscule, une minuscule, et au moins un caractère spécial.',
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                    ],
                    'row_attr' => [
                        'class' => 'form-floating',
                    ],
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Regex(
                            array(
                                #regex pour un mot de passe fort : 6 caractères dont une majuscule, une minuscule et au moins un caractère spécial
                                'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-+_!@#$%^&*., ?]).{6,}$/',
                                'message' => 'Le mot de passe n\'est pas valide, veuillez vérifier les conditions ci-dessus',
                            )
                        ),
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}

