<?php
namespace Master\TrainingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function getName()
    {
        return "contact_form";
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
        
        ->add('messages', TextareaType::class, array(
            "label" => "Tresć wiadomosci"
        ))
        ->add('save', SubmitType::class, array(
            "label" => "Wyslij"
        ));
    }
    
    public function ConfigureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => "Master\TrainingBundle\Entity\Contact"
        ));
    }
}

