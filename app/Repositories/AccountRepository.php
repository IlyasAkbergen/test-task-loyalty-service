<?php

namespace App\Repositories;

use App\DTO\AccountDTO;

interface AccountRepository
{
    public function create(AccountDTO $dto): AccountDTO;

    public function activate(string $search_field, $search_value): bool;

    public function deactivate(string $search_field, $search_value): bool;

    public function balance(string $search_field, $search_value);
}
