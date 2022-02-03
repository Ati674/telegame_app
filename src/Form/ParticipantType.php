<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ParticipantType extends AbstractType
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $builder
            ->add('name', TextType::class, array(
                'attr' => [
                    'class' => 'form-control form-control-sm col-3',
                ],
                'label' => 'Nom:',
                'label_attr' => [
                    'class' => 'col-lg-6'
                ],
                'required' => true
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ],
                'label' => 'Adresse e-mail:',
                'label_attr' => [
                    'class' => 'col-lg-6'
                ],
                'required' => true
            ))
            ->add('telegram', TextType::class, array(
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => '@telegram_user'
                ],
                'label' => 'Nom Telegram:',
                'label_attr' => [
                    'class' => 'col-lg-6'
                ],
                'required' => true
            ))
            ->add('ticketNumber', IntegerType::class, array(
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ],
                'label' => 'Nombre de ticket souhaité:',
                'label_attr' => [
                    'class' => 'col-lg-8'
                ],
                'required' => true,
            ))
            ->add('imageFile', VichImageType::class, [
                'attr' => ['class' => 'uk-input uk-form-width-medium'],
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ])
        ;
        if (!in_array($request->attributes->get('_route'), ['front_home', 'front_render_form_participate'])) {
            $builder
                ->add(
                    'isValid',
                    CheckboxType::class,
                    [
                        'attr' => ['class' => 'uk-checkbox ab-checkbox'],
                        'required' => false,
                        'label' => 'Paiement validé'
                    ]
                )
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
