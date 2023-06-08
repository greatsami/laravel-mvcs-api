<?php

declare(strict_types=1);

namespace App\Modules\Sanctum;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SanctumService
{

    public function __construct(private SanctumValidator $sanctumValidator)
    {
    }

    public function issueToken(array $rawData): string
    {
        $this->sanctumValidator->validateIssueToken($rawData);

        $data = SanctumAuthorizeRequestMapper::mapFrom($rawData);

        $user = User::where("email", $data->getEmail())->first();

        if (!$user || !Hash::check($data->getPassword(), $user->password)) {
            throw new BadRequestException("The provided credential are incorrect");
        }
        return $user->createToken($data->getDevice())->plainTextToken;
    }
}
