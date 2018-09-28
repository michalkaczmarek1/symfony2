<?php
namespace Master\TrainingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType
{
    public function getName() 
    {
        return "register_form";
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('name', TextType::class, array(
                    "label" => "Imię i nazwisko"
                ))
                ->add('email', EmailType::class, array(
                    "label" => "Email"
                ))
                ->add('sex', ChoiceType::class, array(
                    "label" => "Płeć",
                    "choices" => array(
                        "Mężczyzna" => "m",
                        "Kobieta" => "f"
                    ),
                    'choices_as_values' => true,
                    "expanded" => true
                ))
                ->add('birthdate', BirthdayType::class, array(
                    "placeholder" => "--",
                    "label" => "Data urodzenia"
                ))
                ->add('country', CountryType::class, array(
                    "placeholder" => "--",
                    "label" => "Kraj"
                ))
                ->add('course', ChoiceType::class, array(
                    "label" => "Kurs",
                    "choices" => array(
                        "Kurs podstawowy" => "basic",
                        "Analiza techniczna" => "at",
                        "Analiza fundamentalna" => "at",
                        "Kurs zaawansowany" => "master"
                    ),
                    "placeholder" => "--",
                    "empty_data" => NULL,
                    'choices_as_values' => true
                ))
                ->add('invest', ChoiceType::class, array(
                    "label" => "Inwestycje",
                    "choices" => array(
                        "Akcje" => "a",
                        "Obligacje" => "o",
                        "Forex" => "f",
                        "ETF" => "etf"
                    ),
                    'choices_as_values' => true,
                    "expanded" => true,
                    "multiple" => true
                ))
                ->add('comments', TextareaType::class, array(
                    "label" => "Dodatkowy komentarz"
                ))
                ->add('paymentFile', FileType::class, array(
                    "label" => "Potwierdzenie zapłaty"
                ))
                ->add('rules', CheckboxType::class, array(
                    "label" => "Akceptuję regulamin szkolenia",
                    "constraints" => array(
                        new Assert\NotBlank()
                    ),
                    "mapped" => false
                ))
                ->add('save', SubmitType::class, array(
                    "label" => "Zapisz"
                ));
    }
    
    public function ConfigureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => "Master\TrainingBundle\Entity\Register"
        ));
    }
}

