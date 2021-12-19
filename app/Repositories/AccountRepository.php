<?php

namespace App\Repositories;

use App\DTO\AccountDTO;

interface AccountRepository
{
    public function create(AccountDTO $dto): AccountDTO;

    public function activate($type, $id);

    public function deactivate($type, $id);

    public function balance($type, $id);
}
