<?php

namespace Someniatko\FormTransformer;

use Someniatko\FormTransformer\Exception\UnexpectedValueException;

interface FieldTransformerInterface
{
    /**
     * Transforms form field value into normalized one
     * @param string $formFieldValue
     * @return mixed
     * @throws UnexpectedValueException
     */
    public function transformField(string $formFieldValue);

    /**
     * Returns default field normalized value if form data does not contains the field
     * @return mixed
     */
    public function getDefaultValue();
}
