<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User\Form;

use App\Application\User\BanUserCommand;
use App\Domain\User\UserId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Traversable;

/**
 * BanUserType
 *
 * @package App\UserInterface\Web\User\Form
 */
final class BanUserType extends AbstractType implements DataMapperInterface
{

    public function __construct(private readonly TranslatorInterface $translator)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reason', TextareaType::class, [
                "label" => "Ban reason",
                "constraints" => new NotBlank(message: $this->translator->trans(
                    "The ban reason will be presented to the user when he tries to log in. It cannot be blank."
                ))
            ])
            ->add('userId', HiddenType::class)
            ->setDataMapper($this);
    }

    /**
     * @inheritDoc
     */
    public function mapDataToForms(mixed $viewData, Traversable $forms): void
    {
        if (!$viewData instanceof BanUserCommand) {
            return;
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms["userId"]->setData((string) $viewData->userId());
        $forms["reason"]->setData($viewData->reason());
    }

    /**
     * @inheritDoc
     */
    public function mapFormsToData(Traversable $forms, mixed &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $viewData = new BanUserCommand(
            new UserId($forms["userId"]->getData()),
            $forms['reason']->getData(),
        );
    }
}
