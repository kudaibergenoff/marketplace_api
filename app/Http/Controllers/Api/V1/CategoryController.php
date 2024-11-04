<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     description="Схема категории",
 *     @OA\Property(property="id", type="integer", description="ID категории"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, description="ID родительской категории"),
 *     @OA\Property(property="name", type="string", description="Название категории"),
 *     @OA\Property(property="slug", type="string", description="Уникальный идентификатор категории"),
 *     @OA\Property(property="description", type="string", nullable=true, description="Описание категории"),
 *     @OA\Property(property="status", type="boolean", description="Статус категории (активна или нет)")
 * )
 */
class CategoryController extends BaseController
{
    public function __construct(private CategoryService $categoryService) {}

    /**
     * @OA\Get(
     *     path="/api/v1/categories/get",
     *     tags={"Категории"},
     *     summary="Получить список категорий",
     *     security={ {"bearer": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Список категорий",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Category")
     *         )
     *     )
     * )
     */
    public function getCategories(): JsonResponse
    {
        $categories = $this->categoryService->getAll();
        return $this->successResponse($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/categories/create",
     *     tags={"Категории"},
     *     summary="Добавить категорию",
     *     security={ {"bearer": {}} },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="parent_id", type="integer", nullable=true, description="ID родительской категории"),
     *             @OA\Property(property="name", type="string", description="Название категории"),
     *             @OA\Property(property="slug", type="string", description="Уникальный идентификатор категории"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Описание категории"),
     *             @OA\Property(property="status", type="boolean", description="Статус категории")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Категория успешно добавлена",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        $createdCategory = $this->categoryService->create($request->validated());
        return $this->successResponse($createdCategory, Response::HTTP_CREATED, 'Категория успешно добавлена');
    }

    /**
     * @OA\Put(
     *     path="/api/v1/categories/{id}/update",
     *     tags={"Категории"},
     *     summary="Обновить категорию",
     *          security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID категории",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="parent_id", type="integer", nullable=true, description="ID родительской категории"),
     *             @OA\Property(property="name", type="string", description="Название категории"),
     *             @OA\Property(property="slug", type="string", description="Уникальный идентификатор категории"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Описание категории"),
     *             @OA\Property(property="status", type="boolean", description="Статус категории")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Категория успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function updateCategory(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $this->categoryService->update($request->validated(), $id);
        return $this->successResponse([], Response::HTTP_OK, 'Категория успешно обновлена');
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/categories/{id}/delete",
     *     tags={"Категории"},
     *     summary="Удалить категорию",
     *          security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID категории",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Категория успешно удалена",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория не найдена"
     *     )
     * )
     */
    public function deleteCategory(int $id): JsonResponse
    {
        $this->categoryService->delete($id);
        return $this->successResponse(null, Response::HTTP_OK, 'Категория успешно удалена');
    }
}
