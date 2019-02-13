<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class CompositeAttribute implements \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{
    use HasAttributes;


    public function __construct(array $attributes)
    {
        $this->setRawAttributes($attributes, true);
    }

    public function getIncrementing()
    {
        return false;
    }

    public function toArray()
    {
        return $this->attributesToArray();
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodingException(json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function offsetExists($offset)
    {
        return !is_null($this->getAttribute($offset));
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }
}