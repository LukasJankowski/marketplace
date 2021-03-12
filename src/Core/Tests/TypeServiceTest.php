<?php

namespace Marketplace\Core\Tests;

use Marketplace\Core\Type\TypeService;
use Tests\TestCase;

class TypeServiceTest extends TestCase
{
    public function testReturnsTrueIfKeyExists()
    {
        $this->assertTrue(TypeService::keyExists('customer'));
    }

    public function testReturnsFalseIfKeyDoesNotExist()
    {
        $this->assertFalse(TypeService::keyExists('invalid-key'));
    }

    public function testReturnsTrueIfClassExists()
    {
        $this->assertTrue(TypeService::classExists('customer'));
    }

    public function testReturnsFalseIfClassDoesNotExist()
    {
        $this->assertFalse(TypeService::classExists('invalid-class'));
    }

    public function testCanGetClassByKey()
    {
        $this->assertEquals(
            'customer',
            TypeService::getClassByKey('customer')
        );
    }

    public function testThrowsExceptionWhenUsingUnknownKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        TypeService::getClassByKey('invalid-key');
    }

    public function testCanGetKeyByClass()
    {
        $this->assertEquals(
            'customer',
            TypeService::getKeyByClass('customer')
        );
    }

    public function testThrowsExceptionWhenUsingUnknownClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        TypeService::getKeyByClass('invalid-class');
    }

    public function testCanGetAllKeys()
    {
        $this->assertEquals(
            array_keys(TypeService::TYPES),
            TypeService::getKeys()
        );
    }

    public function testCanGetAllKeysExcept()
    {
        $this->assertEquals(
            ['customer', 'provider'],
            TypeService::getKeys(['admin'])
        );
    }

    public function testCanGetAllClasses()
    {
        $this->assertEquals(
            array_values(TypeService::TYPES),
            TypeService::getClasses()
        );
    }

    public function testCangetAllClassesExcept()
    {
        $this->assertEquals(
            ['customer', 'provider'],
            TypeService::getClasses(['admin'])
        );
    }

    public function testCanGetRouteRegexFromKeys()
    {
        $this->assertEquals(
            '^(?:customer|provider|admin)$',
            TypeService::getRouteRegexFromKeys()
        );
    }

    public function testCanGetRouteRegexFromKeysExcept()
    {
        $this->assertEquals(
            '^(?:customer|provider)$',
            TypeService::getRouteRegexFromKeys(['admin'])
        );
    }
}
