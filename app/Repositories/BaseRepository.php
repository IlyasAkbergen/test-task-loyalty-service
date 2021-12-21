<?php

namespace App\Repositories;

interface BaseRepository
{
    public function with(array $relationships): self;
}
