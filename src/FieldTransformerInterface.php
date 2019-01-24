<?php

namespace Someniatko\FormTransformer;

interface FieldTransformerInterface
{
    /**
     * Transforms form field value into normalized one
     * @param mixed $formFieldValue
     * @return mixed
     */
    public function transformField($formFieldValue);

    /**
     * Returns default field normalized value if form data does not contains the field
     * @return mixed
     */
    public function getDefaultValue();
}
