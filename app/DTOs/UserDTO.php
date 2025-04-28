<?php

namespace App\DTOs;

use Illuminate\Http\Request;

readonly class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ){
    }

    public static function fromRequest(Request $request)
    {
        return new self(
          name: $request->name,
          email: $request->email,
          password: $request->password
        );
    }

}
