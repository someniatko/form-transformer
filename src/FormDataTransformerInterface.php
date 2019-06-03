<?php

namespace Someniatko\FormTransformer;

use Someniatko\FormTransformer\Exception\UnexpectedValueException;

interface FormDataTransformerInterface
{
    /**
     * Transforms form data into normalized data, from which an entity
     * can be denormalized by given config.
     *
     * @param array $formData Data from HTTP form
     * @param array $config configuration of form field transformers in format:
     *     string => string
     *     field name => FieldTransformer class
     * Fields not specified in the config will be left as is.
     * @return array Normalized data
     * @throws UnexpectedValueException
     */
    public function transform(array $formData, array $config) :array;
}
