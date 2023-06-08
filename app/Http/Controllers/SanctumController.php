<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Core\HTTPResponseCodes;
use App\Modules\Sanctum\SanctumService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SanctumController extends Controller
{

    public function __construct(private SanctumService $sanctumService)
    {
    }

    public function issueToken(Request $request): Response
    {
        try {
            $dataArray = ($request->toArray() !== [])
                ? $request->toArray()
                : $request->json()->all();

            return new Response(
                $this->sanctumService->issueToken($dataArray),
                HTTPResponseCodes::Success['code']
            );


        } catch (\Exception $exception) {
            return new Response(
                [
                    "exception" => get_class($exception),
                    "errors" => $exception->getMessage(),
                ], HTTPResponseCodes::BadRequest['code']
            );
        }
    }
}
