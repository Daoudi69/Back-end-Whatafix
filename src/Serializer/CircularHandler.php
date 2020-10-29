<?php

namespace App\Serializer;

class CircularHandler {

    public function __invoke($object)
    {
        return $object->getId();
    }
}