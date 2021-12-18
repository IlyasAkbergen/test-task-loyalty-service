<?php

namespace App\Repositories;

interface AccountRepository
{
    public function create(); // todo add dto

    public function activate($type, $id);

    public function deactivate($type, $id);

    public function balance($type, $id);
}
