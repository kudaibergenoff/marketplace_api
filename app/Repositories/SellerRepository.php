<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Models\User;

class SellerRepository extends BaseRepository
{
    public function __construct(private User $seller){
        parent::__construct($seller);
    }
}
