<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getRolesByUserId(int $userId): Collection
    {
        return $this->model->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}
