<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * return user access token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     *
     *
     * @OA\Post (
     *      path="/comments/search",
     *      summary="Search comments by string",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"email","password"},
     *               @OA\Property(property="email", type="string", example="email@email.email"),
     *               @OA\Property(property="password", type="string", example="123")
     *           ),
     *       ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Invalid request")
     *  )
     */
    public function getAccessToken(Request $request)
    {
        $request->validate([
           'email' => 'required|string|email',
           'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if( !$user || !Hash::check($request->password, $user->password) ) {
            throw ValidationException::withMessages([
                'invalid data'
            ]);
        }

        return response()->json(['token' => $user->createToken($request->email)->plainTextToken]);
    }
}
