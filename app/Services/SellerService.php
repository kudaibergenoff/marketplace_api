<?php

namespace App\Services;

use App\Models\Seller;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Repositories\SellerRepository;

class SellerService
{
    public function __construct(private SellerRepositoryInterface $sellerRepository) {}

    public function get()
    {
        return $this->sellerRepository->all();
    }

    public function create(array $data)
    {
        return $this->sellerRepository->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->sellerRepository->update($id, $data);
    }

    public function delete(int $id): ?bool
    {
        return $this->sellerRepository->delete($id);
    }
}
