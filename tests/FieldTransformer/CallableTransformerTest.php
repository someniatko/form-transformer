<?php declare(strict_types = 1);

namespace Tests\FieldTransformer;

use Someniatko\FormTransformer\FieldTransformer\CallableTransformer;
use PHPUnit\Framework\TestCase;

final class CallableTransformerTest extends TestCase
{
    public function testGetDefaultValue() :void
    {
        $transformer = new CallableTransformer(function($val) { return $val; }, '123');

        $this->assertSame('123', $transformer->getDefaultValue());
    }
}
