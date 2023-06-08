<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Core\HTTPResponseCodes;
use App\Modules\StudentCourseEnrollments\StudentCourseEnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentCourseEnrollmentController extends Controller
{

    public function __construct(private readonly StudentCourseEnrollmentService $studentCourseEnrollmentService)
    {
    }

    public function get(int $id): Response
    {
        try {
            return new Response($this->studentCourseEnrollmentService->get($id)->toArray());
        } catch (\Exception $exception) {
            return new Response(
                [
                    "exception" => get_class($exception),
                    "errors" => $exception->getMessage(),
                ], HTTPResponseCodes::BadRequest['code']
            );
        }
    }

    public function update(Request $request): Response
    {
        try {
            $dataArray = ($request->toArray() !== [])
                ? $request->toArray()
                : $request->json()->all();

            return new Response(
                $this->studentCourseEnrollmentService->update($dataArray)->toArray(),
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

    public function softDelete(int $id): Response
    {
        try {
            return new Response($this->studentCourseEnrollmentService->softDelete($id));
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
