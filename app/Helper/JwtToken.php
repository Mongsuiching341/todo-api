<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken
{

    public static function createToken($userId, $userEmail)
    {

        $key = env('JWT_KEY');


        $payload = [
            'iss' => 'todo-api',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'user_id' => $userId,
            'user_email' => $userEmail,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyToken($token)
    {

        $key = env('JWT_KEY');

        try {
            if ($token == null) {
                return 'Unauthorized';
            } else {
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }
        } catch (Exception $e) {
            return 'token invalid';
        }
    }
}
