<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepositoryEloquent implements BaseRepository
{
    protected Model|Builder $model;

    public function with(array $relationships): self
    {
        $this->model = $this->model->with($relationships);
        return $this;
    }
}
