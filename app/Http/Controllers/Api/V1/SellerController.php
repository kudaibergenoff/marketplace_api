<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Models\Seller;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *     schema="Seller",
 *     type="object",
 *     title="Seller",
 *     description="Схема продавца",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID продавца"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Имя продавца"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email продавца"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Телефон продавца в формате 77001234567"
 *     )
 * )
 */
class SellerController extends BaseController
{
    public function __construct(private SellerService $sellerService) {}

    /**
     * @OA\Get(
     *     path="/api/v1/sellers/get",
     *     tags={"Продавцы"},
     *     summary="Получить список продавцов",
     *     security={ {"bearer": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Список продавцов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Seller")
     *         )
     *     )
     * )
     */
    public function getSellers(): JsonResponse
    {
        $sellers = $this->sellerService->get();

        return $this->successResponse($sellers);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/sellers/create",
     *     tags={"Продавцы"},
     *     summary="Добавить продавцов",
     *     security={ {"bearer": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Имя продавца"),
     *             @OA\Property(property="email", type="string", format="email", description="Email продавца"),
     *             @OA\Property(property="phone", type="string", description="Телефон продавца в формате 77001234567"),
     *             @OA\Property(property="password", type="string", description="Пароль продавца"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Успешно"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка проверки"
     *     )
     * )
     *
     * @param CreateSellerRequest $request
     * @return JsonResponse
     */
    public function createSeller(CreateSellerRequest $request): JsonResponse
    {
        $seller = $this->sellerService->create($request->validated());

        return $this->successResponse($seller, Response::HTTP_CREATED, 'Продавец успешно добавлен');
    }

    /**
     * @OA\Put(
     *     path="/api/v1/sellers/{id}/update",
     *     tags={"Продавцы"},
     *     summary="Обновить данные продавца",
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продавца",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Имя продавца"),
     *             @OA\Property(property="email", type="string", format="email", description="Email продавца"),
     *             @OA\Property(property="phone", type="string", description="Телефон продавца")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно обновлено",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продавец не найден"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка проверки"
     *     )
     * )
     *
     * @param UpdateSellerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateSeller(UpdateSellerRequest $request, int $id): JsonResponse
    {
        $this->sellerService->update($request->validated(), $id);

        return $this->successResponse([], Response::HTTP_OK, 'Продавец успешно обновлен');
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/sellers/{id}/delete",
     *     tags={"Продавцы"},
     *     summary="Удалить продавца",
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID продавца",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Продавец успешно удален",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продавец не найден"
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteSeller(Request $request, int $id): JsonResponse
    {
        $this->sellerService->delete($id);
        return $this->successResponse(null, Response::HTTP_OK, 'Продавец успешно удален');
    }
}
