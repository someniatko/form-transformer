<?php declare(strict_types = 1);

namespace Tests\FieldTransformer;

use PHPUnit\Framework\TestCase;
use Someniatko\FormTransformer\FieldTransformer\IntegerField;

final class IntegerFieldTest extends TestCase
{
    /**
     * @dataProvider fieldDataProvider
     */
    public function testTransformField($field, $expected) :void
    {
        $this->assertSame($expected, (new IntegerField)->transformField($field));
    }

    public function fieldDataProvider() :iterable
    {
        yield [ '', null ];
        yield [ '1', 1 ];
        yield [ '-1', -1 ];
    }

    public function testGetDefaultValue() :void
    {
        $this->assertNull((new IntegerField)->getDefaultValue());
    }

    public function testNonNumericValueResultsInException(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        (new IntegerField)->transformField('abcd');
    }
}
