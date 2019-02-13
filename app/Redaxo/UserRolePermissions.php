<?php

namespace App\Redaxo;

use App\CompositeAttribute;

/**
 * @property-read string[] $general
 * @property-read string[] $options
 * @property-read string[] $extras
 * @property-read int[] $clang
 * @property-read int[] $media
 * @property-read int[] $structure
 * @property-read int[] $modules
 */
class UserRolePermissions extends CompositeAttribute
{

    protected $casts = [
        'general' => 'pipe_array',
        'options' => 'pipe_array',
        'extras' => 'pipe_array',
        'clang' => 'int_pipe_array',
        'media' => 'int_pipe_array',
        'structure' => 'int_pipe_array',
        'modules' => 'int_pipe_array',
    ];


    protected function castAttribute($key, $value)
    {
        switch ($this->getCastType($key)) {
            case 'pipe_array':
                return $this->castPipeArray($value);
            case 'int_pipe_array':
                return array_map('intval', $this->castPipeArray($value));
            default:
                return parent::castAttribute($key, $value);
        }
    }

    protected function castPipeArray($value): array
    {
        return is_null($value) ? [] : explode('|', trim($value, '|'));
    }
}