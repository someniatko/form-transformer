<?php declare(strict_types = 1);

namespace Someniatko\FormTransformer\FieldTransformer;

use Someniatko\FormTransformer\FieldTransformerInterface;

final class CheckboxField implements FieldTransformerInterface
{
    public function transformField(string $formFieldValue)
    {
        return $formFieldValue !== '';
    }

    public function getDefaultValue()
    {
        return false;
    }
}
