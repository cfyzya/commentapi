<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;

class UserController extends Controller
{
    public function __construct(private RegisterService $registerService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $token = $this->registerService->register(UserDTO::fromRequest($request));
        return response()->json(['token' => $token]);
    }
}
