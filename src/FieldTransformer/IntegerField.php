<?php declare(strict_types = 1);

namespace Someniatko\FormTransformer\FieldTransformer;

use Someniatko\FormTransformer\Exception\UnexpectedValueException;
use Someniatko\FormTransformer\FieldTransformerInterface;

final class IntegerField implements FieldTransformerInterface
{
    public function transformField(string $formFieldValue)
    {
        if ($formFieldValue === '') {
            return null;
        }

        if (!is_numeric($formFieldValue)) {
            throw new UnexpectedValueException;
        }

        return (int)$formFieldValue;
    }

    public function getDefaultValue()
    {
        return null;
    }
}
