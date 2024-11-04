<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getPermissionsByRoleId(int $roleId): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();
    }
}
