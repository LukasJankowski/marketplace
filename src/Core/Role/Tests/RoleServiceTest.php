<?php

namespace Marketplace\Core\Role\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Marketplace\Core\Role\RoleService;
use Marketplace\Core\User\User;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsTrueIfKeyExists()
    {
        $this->assertTrue(RoleService::slugExists('customer'));
    }

    public function testReturnsFalseIfKeyDoesNotExist()
    {
        $this->assertFalse(RoleService::slugExists('invalid-key'));
    }

    public function testReturnsTrueIfClassExists()
    {
        $this->assertTrue(RoleService::roleExists('customer'));
    }

    public function testReturnsFalseIfClassDoesNotExist()
    {
        $this->assertFalse(RoleService::roleExists('invalid-class'));
    }

    public function testCanGetClassByKey()
    {
        $this->assertEquals(
            'customer',
            RoleService::getRoleBySlug('customer')
        );
    }

    public function testThrowsExceptionWhenUsingUnknownKey()
    {
        $this->expectException(InvalidArgumentException::class);
        RoleService::getRoleBySlug('invalid-key');
    }

    public function testCanGetKeyByClass()
    {
        $this->assertEquals(
            'customer',
            RoleService::getSlugByRole('customer')
        );
    }

    public function testThrowsExceptionWhenUsingUnknownClass()
    {
        $this->expectException(InvalidArgumentException::class);
        RoleService::getSlugByRole('invalid-class');
    }

    public function testCanGetAllKeys()
    {
        $this->assertEquals(
            array_keys(RoleService::ROLES),
            RoleService::getSlugs()
        );
    }

    public function testCanGetAllKeysExcept()
    {
        $this->assertEquals(
            ['customer', 'provider'],
            RoleService::getSlugs(['admin'])
        );
    }

    public function testCanGetAllClasses()
    {
        $this->assertEquals(
            array_values(RoleService::ROLES),
            RoleService::getRoles()
        );
    }

    public function testCangetAllClassesExcept()
    {
        $this->assertEquals(
            ['customer', 'provider'],
            RoleService::getRoles(['admin'])
        );
    }

    public function testCanGetRouteRegexFromKeys()
    {
        $this->assertEquals(
            '^(?:customer|provider|admin)$',
            RoleService::getRouteRegexFromSlugs()
        );
    }

    public function testCanGetRouteRegexFromKeysExcept()
    {
        $this->assertEquals(
            '^(?:customer|provider)$',
            RoleService::getRouteRegexFromSlugs(['admin'])
        );
    }

    public function testCanGetRoleFromUser()
    {
        $u = User::factory()->create(['role' => 'customer']);

        $this->assertEquals($u->getAttribute('role'), RoleService::getRoleOfUser($u));
    }
}
