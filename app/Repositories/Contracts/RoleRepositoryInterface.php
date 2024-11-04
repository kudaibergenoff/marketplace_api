<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function getRolesByUserId(int $userId): Collection;
}
