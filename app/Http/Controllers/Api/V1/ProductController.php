<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Notifications\ProductModerationNotification;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;


class ProductController extends BaseController
{
    /**
     * @OA\Schema(
     *     schema="Product",
     *     type="object",
     *     title="Product",
     *     description="Схема товара",
     *     @OA\Property(property="id", type="integer", description="ID товара"),
     *     @OA\Property(property="name", type="string", description="Название товара"),
     *     @OA\Property(property="description", type="string", nullable=true, description="Описание товара"),
     *     @OA\Property(property="price", type="number", format="float", description="Цена товара"),
     *     @OA\Property(property="attributes", type="array",
     *         @OA\Items(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID атрибута"),
     *             @OA\Property(property="name", type="string", description="Название атрибута"),
     *             @OA\Property(property="value", type="string", description="Значение атрибута")
     *         )
     *     )
     * )
     */
    public function __construct(private ProductService $productService) {}

    /**
     * @OA\Get(
     *     path="/api/v1/products/get",
     *     tags={"Продукты"},
     *     summary="Получить список товаров",
     *     security={ {"bearer": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Список товаров",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function getProducts(Request $request): JsonResponse
    {
        $products = $this->productService->getProducts();

        return response()->json($products);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/products/create",
     *     tags={"Продукты"},
     *     summary="Добавить продукт",
     *     security={ {"bearer": {}} },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название продукта"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Описание продукта"),
     *             @OA\Property(property="price", type="string", nullable=true, description="Цена продукта"),
     *             @OA\Property(property="category_id", type="string", description="Категория"),
     *             @OA\Property(property="attributes", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="attribute_name", type="string", description="Название атрибута"),
     *                     @OA\Property(property="attribute_value", type="string", description="Значение атрибута")
     *                 ),
     *                 description="Атрибуты продукта"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Продукт успешно добавлен",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function createProduct(CreateProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['seller_id'] = auth()->id();

        $product = $this->productService->createProduct($validatedData);

        foreach ($validatedData['attributes'] as $attribute) {
            $this->productService->addAttributeToProduct($product->id, $attribute);
        }

        return $this->successResponse($product, Response::HTTP_CREATED, 'Товар успешно добавлен');
    }

    /**
     * @OA\Put(
     *     path="/api/v1/products/{id}/update",
     *     tags={"Продукты"},
     *     summary="Обновить продукт",
     *     security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продукт",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название товара"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Описание товара"),
     *             @OA\Property(property="price", type="number", format="float", description="Цена товара"),
     *             @OA\Property(property="attributes", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="ID атрибута"),
     *                     @OA\Property(property="name", type="string", description="Название атрибута"),
     *                     @OA\Property(property="value", type="string", description="Значение атрибута")
     *                 ),
     *                 description="Атрибуты товара"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукт успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function updateProduct(UpdateProductRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();

        $product = $this->productService->updateProduct($validatedData, $id);

        if (isset($validatedData['attributes'])) {
            foreach ($validatedData['attributes'] as $attribute) {
                $this->productService->upsertAttributeForProduct($id, $attribute);
            }
        }

        return $this->successResponse([], Response::HTTP_OK, 'Товар успешно обновлен');
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/products/{id}/delete",
     *     tags={"Продукты"},
     *     summary="Удалить продукт",
     *     security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продукт",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукт успешно удален",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден"
     *     )
     * )
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return $this->successResponse([], Response::HTTP_OK, 'Товар успешно удален');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products/get-for-moderation",
     *     tags={"Продукты"},
     *     summary="Получить продукты для модерации",
     *     security={ {"bearer": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Продукты для модерации получены",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизован",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Нет доступа",
     *     )
    )
     */
    public function getProductsForModeration(): JsonResponse
    {
        $products = $this->productService->getProductsForModeration();

        return $this->successResponse($products, Response::HTTP_OK, 'Товары для модерации получены');
    }

    /**
     * @OA\Put(
     *     path="/api/v1/products/{id}/approve",
     *     tags={"Продукты"},
     *     summary="Одобрить продукт",
     *     security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продукт",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукт успешно одобрен",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Нет доступа",
     *     )
    )
     */
    public function approveProduct(int $id): JsonResponse
    {
        $product = $this->productService->approveProduct($id);

        //$product->seller->notify(new ProductModerationNotification($product, 'одобрен'));

        return $this->successResponse($product, Response::HTTP_OK, 'Товар успешно одобрен');
    }

    /**
     * @OA\Put(
     *     path="/api/v1/products/{id}/reject",
     *     tags={"Продукты"},
     *     summary="Отклонить товар",
     *     security={ {"bearer": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продукт",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продукт успешно отклонен",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Нет доступа",
     *     )
    )
     */
    public function rejectProduct(int $id): JsonResponse
    {
        $product = $this->productService->rejectProduct($id);

        //$product->seller->notify(new ProductModerationNotification($product, 'отказан'));

        return $this->successResponse($product, Response::HTTP_OK, 'Товар успешно отклонен');
    }
}
