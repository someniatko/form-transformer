<?php declare(strict_types = 1);

namespace Someniatko\FormTransformer\FieldTransformer;

use Someniatko\FormTransformer\FieldTransformerInterface;

final class CallableTransformer implements FieldTransformerInterface
{
    private $callback;
    private $defaultValue;

    public function __construct(callable $callback, $defaultValue = null)
    {
        $this->callback = $callback;
        $this->defaultValue = $defaultValue;
    }

    public function transformField(string $formFieldValue)
    {
        return ($this->callback)($formFieldValue);
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
