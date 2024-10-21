<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User\Form;

use App\Application\User\RemoveUserAccountCommand;
use App\Domain\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Email as EmailValidator;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * RemoveUserAccountType
 *
 * @package App\UserInterface\Web\User\Form
 */
final class RemoveUserAccountType extends AbstractType implements DataMapperInterface
{

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly User\UserRepository $users
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User|null $user */
        $userId = isset($options['data']) ? $options['data']->userId() : null;
        $user = $userId ? $this->users->withId($userId) : null;
        $builder
            ->add('email', EmailType::class, [
                "label" => $this->translator->trans("Enter email address \"%email%\" to delete your account", ['%email%' => $user->email()]),
                "attr" => [
                    "placeholder" => $user?->email(),
                ],
                "constraints" => [
                    new NotBlank(message: $this->translator->trans("Please enter the account email address to remove account.")),
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
        if (!$viewData instanceof RemoveUserAccountCommand) {
            return;
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms["userId"]->setData((string) $viewData->userId());
    }

    /**
     * @inheritDoc
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $viewData = new RemoveUserAccountCommand(
            new User\UserId($forms['userId']->getData())
        );
    }
}
