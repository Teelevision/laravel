<?php

namespace App\Redaxo;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method bool hasPermission(string $permission)
 * @method bool hasOption(string $option)
 * @method bool hasExtra(string $extra)
 * @method bool hasClang(int $clang)
 * @method bool hasMedium(int $medium)
 * @method bool hasStructure(int $structure)
 * @method bool hasModule(int $module)
 */
class UserRoleCollection extends Collection
{

    public function __call($method, $parameters)
    {
        if (starts_with($method, 'has')) {
            return $this->checkHasMethod($method, $parameters);
        }
        return parent::__call($method, $parameters);
    }

    protected function checkHasMethod($method, $parameters): bool
    {
        foreach ($this->items as $item) {
            if ($item->{$method}(...$parameters)) {
                return true;
            }
        }
        return false;
    }
}