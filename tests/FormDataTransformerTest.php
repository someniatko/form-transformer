<?php declare(strict_types = 1);

namespace Tests;

use Someniatko\FormTransformer\FieldTransformerInterface;
use Someniatko\FormTransformer\FormDataTransformer;
use PHPUnit\Framework\TestCase;

class BorkTransformer implements FieldTransformerInterface
{
    public function transformField(string $formFieldValue)
    {
        return $formFieldValue.'-bork';
    }

    public function getDefaultValue()
    {
        return 'bork';
    }
}

final class TransformerWithConstructor implements FieldTransformerInterface
{
    private $addition;

    public function __construct(string $addition)
    {
        $this->addition = $addition;
    }

    public function transformField(string $formFieldValue)
    {
        return $formFieldValue.$this->addition;
    }

    public function getDefaultValue()
    {
        return null;
    }
}

final class FormDataTransformerTest extends TestCase
{
    public function testTransformWithoutConfig() :void
    {
        $formData = [
            'a' => 'b',
            'c' => 'd',
        ];

        $this->assertEquals($formData, (new FormDataTransformer)->transform($formData, []));
    }

    public function testTransformWithConfiguredFields() :void
    {
        $formData = [
            'wolf' => 'woof',
            'fox' => 'what',
            'mouse' => 'squeak',
        ];

        $config = [
            'wolf' => BorkTransformer::class,
            'fox' => BorkTransformer::class,
        ];

        $this->assertEquals([
            'wolf' => 'woof-bork',
            'fox' => 'what-bork',
            'mouse' => 'squeak',
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformArray() :void
    {
        $formData = [
            'wolves' => [
                'woof-1',
                'woof-2',
            ],
            'mice' => [
                'squeak-1',
                'squeak-2',
            ]
        ];

        $config = [
            'wolves' => [
                '_each' => BorkTransformer::class
            ]
        ];

        $this->assertEquals([
            'wolves' => [
                'woof-1-bork',
                'woof-2-bork',
            ],
            'mice' => [
                'squeak-1',
                'squeak-2',
            ]
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformSubEntity() :void
    {
        $formData = [
            'species' => [
                'wolf' => 'woof',
                'fox' => [
                    'goes' => 'silent',
                    'does' => 'what',
                ]
            ]
        ];

        $config = [
            'species' => [
                'wolf' => BorkTransformer::class,
                'fox' => [
                    'does' => BorkTransformer::class,
                ]
            ]
        ];

        $this->assertEquals([
            'species' => [
                'wolf' => 'woof-bork',
                'fox' => [
                    'goes' => 'silent',
                    'does' => 'what-bork',
                ]
            ]
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformArrayOfEntities() :void
    {
        $formData = [
            'species' => [
                'wolves' => [
                    [ 'goes' => 'woof-1' ],
                    [ 'goes' => 'woof-2' ],
                ]
            ]
        ];

        $config = [
            'species' => [
                'wolves' => [
                    '_each' => [ 'goes' => BorkTransformer::class ]
                ]
            ]
        ];

        $this->assertEquals([
            'species' => [
                'wolves' => [
                    [ 'goes' => 'woof-1-bork' ],
                    [ 'goes' => 'woof-2-bork' ],
                ]
            ]
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformFieldMissingInFormData() :void
    {
        $formData = [
            'wolf' => 'woof'
        ];

        $config = [
            'fox' => BorkTransformer::class,
        ];

        $this->assertEquals([
            'wolf' => 'woof',
            'fox' => 'bork', // BorkTransformer#getDefaultValue()
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformArrayMissingInFormData() :void
    {
        $formData = [
            'wolf' => 'woof'
        ];

        $config = [
            'foxes' => [
                '_each' => BorkTransformer::class,
            ]
        ];

        $this->assertEquals([
            'wolf' => 'woof',
            'foxes' => [], // BorkTransformer#getDefaultValue()
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformCallable() :void
    {
        $formData = [
            'wolf' => 'woof',
            'fox' => 'what',
        ];

        $config = [
            'wolf' => function ($value) { return $value.'~~bork'; },
        ];

        $this->assertEquals([
            'wolf' => 'woof~~bork',
            'fox' => 'what',
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformCallableInsideEach() :void
    {
        $formData = [
            'wolves' => [
                'wolf-1',
                'wolf-2',
            ]
        ];
        
        $config = [
            'wolves' => [
                '_each' => function ($value) { return $value.'~~bork'; },
            ]
        ];

        $this->assertEquals([
            'wolves' => [
                'wolf-1~~bork',
                'wolf-2~~bork',
            ],
        ], (new FormDataTransformer)->transform($formData, $config));
    }

    public function testTransformWithTransformerInstance(): void
    {
        $formData = [
            'wolf' => 'boo'
        ];

        $config = [
            'wolf' => new TransformerWithConstructor('-bar')
        ];

        $this->assertEquals([
            'wolf' => 'boo-bar',
        ], (new FormDataTransformer)->transform($formData, $config));
    }
}
