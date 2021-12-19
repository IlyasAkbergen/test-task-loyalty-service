<?php

namespace App\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class AccountDTO extends DataTransferObject
{
    #[MapFrom('phone')]
    public string $phone;

    #[MapFrom('card')]
    public string $card;

    #[MapFrom('email')]
    public string $email;

    #[MapFrom('email_notification')]
    public bool $email_notification = true;

    #[MapFrom('phone_notification')]
    public bool $phone_notification = true;

    #[MapFrom('active')]
    public bool $active = true;
}
