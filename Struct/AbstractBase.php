<?php
namespace Airwallex\CommonLibrary\Struct;

use Airwallex\CommonLibrary\Gateway\PluginService\Log\Log;

abstract class AbstractBase {
    public function __construct(array $dataArray = []) {
        if (!empty($dataArray)) {
            $this->setFromArray($dataArray);
        }
    }

    public function setFromArray(array $dataArray): void {
        foreach ($dataArray as $fieldName => $fieldValue) {
            $propertyName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName))));
            $methodName   = 'set' . ucfirst($propertyName);

            if (method_exists($this, $methodName)) {
                $this->{$methodName}($fieldValue);
            }
        }
    }

    /**
     * Get an array representation of the object
     *
     * @return array
     */
    public function toArray(): array {
        $result = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $result[$property] = $value->toArray();
            } else {
                $result[$property] = $value;
            }
        }
        return $result;
    }
}