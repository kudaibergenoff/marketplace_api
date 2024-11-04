<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends BaseController
{
    public function __construct(private CategoryService $categoryService) {}

    public function getCategories(Request $request): JsonResponse
    {
        return $this->successResponse($this->categoryService->getAll());
    }

    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        $createdCategory = $this->categoryService->create($request->validated());

        return $this->successResponse($createdCategory, Response::HTTP_CREATED);
    }
}
