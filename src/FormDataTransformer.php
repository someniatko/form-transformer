<?php declare(strict_types = 1);

namespace Someniatko\FormTransformer;

use Someniatko\FormTransformer\FieldTransformer\CallableTransformer;

final class FormDataTransformer implements FormDataTransformerInterface
{
    public function transform(array $formData, array $config) :array
    {
        if (array_key_exists('_each', $config)) {
            return $this->transformEach($formData, $config['_each']);
        }

        $normalizedData = $formData;

        foreach ($config as $fieldName => $configNode) {
            if (is_array($configNode)) {
                $normalizedData[ $fieldName ] = isset($formData[ $fieldName ])
                    ? $this->transform($formData[$fieldName], $configNode)
                    : [];
            } else {
                $transformer = $this->createTransformer($configNode);

                $normalizedData[ $fieldName ] = isset($formData[ $fieldName ])
                    ? $transformer->transformField($formData[ $fieldName ])
                    : $transformer->getDefaultValue();
            }
        }

        return $normalizedData;
    }

    private function transformEach(array $formData, $configNode) :array
    {
        return array_map(function ($formDataNode) use ($configNode) {
            if (is_array($configNode)) {
                return $this->transform($formDataNode, $configNode);
            }

            return $this->createTransformer($configNode)->transformField($formDataNode);
        }, $formData);
    }

    private function createTransformer($configNode) :FieldTransformerInterface
    {
        \assert(!is_array($configNode));

        return is_callable($configNode)
            ? new CallableTransformer($configNode)
            : new $configNode;
    }
}
