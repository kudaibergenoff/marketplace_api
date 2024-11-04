<?php

namespace App\Services;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository){}

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function getById(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }
    public function update(array $data, int $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
