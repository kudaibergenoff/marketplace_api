<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Marketplace API",
 *     version="1.0.0",
 *     description="Marketplace API"
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     securityScheme="bearer",
 *     scheme="bearer"
 * )
 */
class BaseController extends Controller
{
    use ApiResponse;
}
