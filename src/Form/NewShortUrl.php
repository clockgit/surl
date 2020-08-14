<?php
// src/Form/Type/TaskType.php
namespace App\Form;

use App\Entity\ShortUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewShortUrl extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('url', TextType::class, ['required' => TRUE, 'label' => 'URL to shorten',])
      ->add('short', TextType::class, ['label' => 'Short Code', 'required' => TRUE, 'attr' => ['maxlength' => 10, 'minlength' => 2,]])
      ->add('save', SubmitType::class, ['label' => 'Shorten URL']);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => ShortUrl::class,
    ]);
  }
}
