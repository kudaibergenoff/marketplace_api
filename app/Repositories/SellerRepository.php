<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Models\User;
use App\Repositories\Contracts\SellerRepositoryInterface;

class SellerRepository extends BaseRepository implements SellerRepositoryInterface
{
    public function __construct(private User $seller){
        parent::__construct($seller);
    }
}
