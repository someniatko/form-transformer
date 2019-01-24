<?php declare(strict_types = 1);

namespace Tests\FieldTransformer;

use PHPUnit\Framework\TestCase;
use Someniatko\FormTransformer\FieldTransformer\StringField;

final class StringFieldTest extends TestCase
{
    /**
     * @dataProvider fieldDataProvider
     */
    public function testTransformField($field, $expected) :void
    {
        $this->assertSame($expected, (new StringField)->transformField($field));
    }

    public function fieldDataProvider() :iterable
    {
        yield [ '', '' ];
        yield [ '1', '1' ];
    }

    public function testGetDefaultValue() :void
    {
        $this->assertNull((new StringField)->getDefaultValue());
    }
}
