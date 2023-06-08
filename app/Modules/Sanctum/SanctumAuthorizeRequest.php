<?php

declare(strict_types=1);

namespace App\Modules\Sanctum;

class SanctumAuthorizeRequest
{

    public function __construct(
        private string $email,
        private string $password,
        private string $device,
    )
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }


}
