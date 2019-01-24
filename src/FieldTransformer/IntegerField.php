<?php declare(strict_types = 1);

namespace Someniatko\FormTransformer\FieldTransformer;

use Someniatko\FormTransformer\FieldTransformerInterface;

final class IntegerField implements FieldTransformerInterface
{
    public function transformField($formFieldValue)
    {
        \assert(is_string($formFieldValue));
        if ($formFieldValue === '') {
            return null;
        }

        \assert(is_numeric($formFieldValue));
        return (int)$formFieldValue;
    }

    public function getDefaultValue()
    {
        return null;
    }
}
