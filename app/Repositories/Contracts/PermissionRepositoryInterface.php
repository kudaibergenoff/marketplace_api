<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface extends RepositoryInterface
{
    public function getPermissionsByRoleId(int $roleId): Collection;
}
