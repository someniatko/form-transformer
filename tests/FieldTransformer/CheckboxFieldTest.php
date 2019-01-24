<?php declare(strict_types = 1);

namespace Tests\FieldTransformer;

use Someniatko\FormTransformer\FieldTransformer\CheckboxField;
use PHPUnit\Framework\TestCase;

final class CheckboxFieldTest extends TestCase
{
    /**
     * @dataProvider fieldDataProvider
     */
    public function testTransformField($field, $expected) :void
    {
        $this->assertSame($expected, (new CheckboxField)->transformField($field));
    }

    public function fieldDataProvider() :iterable
    {
        yield [ '', false ];
        yield [ 'on', true ];
        yield [ 'asdf', true ];
    }

    public function testGetDefaultValue() :void
    {
        $this->assertSame(false, (new CheckboxField)->getDefaultValue());
    }
}
