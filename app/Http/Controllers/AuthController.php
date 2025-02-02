<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $data = [
            'user_id' => auth('api')->user()->id,
            'random' => rand().time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        return $this->respondWithToken($token, $refreshToken);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $refreshToken = request()->get('refresh_token');
        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['user_id']);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            auth('api')->invalidate();

            $token = auth('api')->login($user);
            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Refresh Token Invalid'], 500);
        }
//        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    protected  function createRefreshToken()
    {
        $data = [
            'user_id' => auth('api')->user()->id,
            'random' => rand().time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        return JWTAuth::getJWTProvider()->encode($data);
    }
}
