<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    public function __construct(protected AuthService $authService){}

//    /**
//     * @OA\Post (
//     *     path="/api/v1/register",
//     *     summary="Регистрация",
//     *     tags={"Авторизация"},
//     *     @OA\RequestBody(
//     *         required=true,
//     *         @OA\MediaType(
//     *             mediaType="application/json",
//     *             @OA\Schema(
//     *                 @OA\Property(
//     *                     property="name",
//     *                     description="Имя пользователя",
//     *                     type="string",
//     *                     example="Zhanuzak Kudaibergenov",
//     *                 ),
//     *                 @OA\Property(
//     *                     property="email",
//     *                     description="Email пользователя",
//     *                     type="string",
//     *                     example="admin@marketplace.com",
//     *                 ),
//     *                 @OA\Property(
//     *                     property="phone",
//     *                     description="Телефон пользователя",
//     *                     type="string",
//     *                     example="77071234567",
//     *                 ),
//     *                 @OA\Property(
//     *                     property="password",
//     *                     description="Пароль пользователя",
//     *                     type="string",
//     *                     example="password123",
//     *                 ),
//     *                 @OA\Property(
//     *                     property="password_confirmation",
//     *                     description="Подтверждение пароля",
//     *                     type="string",
//     *                     example="password123",
//     *                 )
//     *             )
//     *         )
//     *     ),
//     *     @OA\Response(
//     *         response=201,
//     *         description="Успешно",
//     *         @OA\JsonContent(
//     *             type="object",
//     *             @OA\Property(property="success", type="boolean", example=true),
//     *             @OA\Property(property="message", type="string", example="Пользователь успешно зарегистрирован"),
//     *         )
//     *     ),
//     *     @OA\Response(
//     *         response=422,
//     *         description="Ошибка проверки"
//     *     )
//     * )
//     *
//     * @param RegisterRequest $request
//     * @return JsonResponse
//     */
//    public function register(RegisterRequest $request): JsonResponse
//    {
//        $user = $this->authService->register($request->validated());
//
//        return $this->successResponse(
//            $user,
//            Response::HTTP_CREATED,
//            'Пользователь успешно зарегистрирован'
//        );
//    }

    /**
     * @OA\Post (
     *     path="/api/v1/login",
     *     summary = "Логин",
     *     tags={"Авторизация"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(
     *             property="email",
     *             description="Email",
     *             type="string",
     *             example="admin@marketplace.com",
     *           ),
     *          @OA\Property(
     *             property="password",
     *             description="Password",
     *             type="string",
     *             example="Aa123123",
     *           ),
     *         ),
     *       ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Пользовтель не найден",
     *      ),
     *     @OA\Response(
     *         response="401",
     *         description="Не авторизован",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка проверки"
     *    )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->only('email', 'password'));
            return $this->successResponse(
                ['token' => $token],
                Response::HTTP_OK,
                'Пользователь успешно авторизован'
            );
        } catch (ValidationException $e) {
            return $this->errorResponse(
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->validator->errors()
            );
        }
    }

    /**
     * @OA\Post (
     *     path="/api/v1/logout",
     *     summary = "Выход",
     *     tags={"Авторизация"},
     *     security={ {"bearer": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Успешно",
     *     )
     * )
     *
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse(null, Response::HTTP_OK, 'Успешный выход из системы');
    }
}
