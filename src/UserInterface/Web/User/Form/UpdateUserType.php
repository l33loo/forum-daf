<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User\Form;

use App\Application\User\UpdateUserCommand;
use App\Domain\User\Email;
use App\Domain\User\UserId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Email as EmailValidator;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * UpdateUserType
 *
 * @package App\UserInterface\Web\User\Form
 */
final class UpdateUserType extends AbstractType implements DataMapperInterface
{

    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "User name",
                "constraints" => new NotBlank(message: $this->translator->trans("User name cannot be blank."))
            ])
            ->add('email', EmailType::class, [
                "label" => $this->translator->trans("Email address"),
                "constraints" => [
                    new NotBlank(message: $this->translator->trans("Email address is used for authentication. It cannot be blank.")),
                    new EmailValidator(message: $this->translator->trans("Invalid mail address."))
                ]
            ])
            ->add('userId', HiddenType::class)
            ->setDataMapper($this);
    }


    /**
     * @inheritDoc
     */
    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        if (!$viewData instanceof UpdateUserCommand) {
            return;
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms["userId"]->setData((string) $viewData->userId());
        $forms["name"]->setData($viewData->name());
        $forms["email"]->setData((string) $viewData->email());
    }

    /**
     * @inheritDoc
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $viewData = new UpdateUserCommand(
            new UserId($forms["userId"]->getData()),
            $forms['name']->getData(),
            new Email($forms['email']->getData())
        );
    }
}
