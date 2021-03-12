<?php

namespace Marketplace\Core\Tests;

use Marketplace\Core\Api\TokenService;
use Tests\TestCase;

class TokenServiceTest extends TestCase
{
    public function testCanCreateAnApiToken()
    {
        $this->assertIsString(TokenService::generateApiToken(1));
        $this->assertStringStartsWith((string) time() . '.', TokenService::generateApiToken(1));
    }

    public function testReturnsTrueWithValidToken()
    {
        $token = TokenService::generateApiToken(1);
        $this->assertTrue(TokenService::isValidToken($token, 1));
    }

    public function testReturnsFalseWithInvalidToken()
    {
        // falsy hash
        $this->assertFalse(TokenService::isValidToken(time() . '.' . md5('not-a-valid-token'), 1));
        // false user
        $this->assertFalse(TokenService::isValidToken(TokenService::generateApiToken(1), 2));
        // falsy format
        $this->assertFalse(TokenService::isValidToken(md5('invalid-token'), 1));
        $this->assertFalse(TokenService::isValidToken(hash('sha512', 'invalid-token'), 1));
        $this->assertFalse(TokenService::isValidToken(md5('invalid-token') . '.' . time(), 1));
        $this->assertFalse(TokenService::isValidToken('123123123123123' . md5('invalid-token'), 1));
        $this->assertFalse(TokenService::isValidToken('', 1));
        $this->assertFalse(TokenService::isValidToken('....' . TokenService::generateApiToken(1), 1));
        // expired time
        $token = time() - (121 * 60);
        $token .= '.' . md5($token . 1 . env('APP_SECRET'));

        $this->assertFalse(TokenService::isValidToken($token, 1));
    }
}
