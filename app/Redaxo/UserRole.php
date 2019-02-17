<?php

namespace App\Redaxo;

/**
 * @property int $id
 * @property string|null $name,
 * @property string|null $description
 * @property UserRolePermissions $perms
 * @property string $createuser
 * @property string $updateuser
 * @property int $revision
 * @method static UserRoleCollection findMany(\Illuminate\Contracts\Support\Arrayable|array $ids, array $columns = ['*'])
 */
class UserRole extends Model
{

    protected $casts = [
        'perms' => UserRolePermissions::class,
    ];


    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->perms->general);
    }

    public function hasOption(string $option): bool
    {
        return in_array($option, $this->perms->options);
    }

    public function hasExtra(string $extra): bool
    {
        return in_array($extra, $this->perms->extras);
    }

    public function hasClang(int $clang): bool
    {
        return in_array($clang, $this->perms->clang);
    }

    public function hasMedium(int $medium): bool
    {
        return in_array($medium, $this->perms->media);
    }

    public function hasStructure(int $structure): bool
    {
        return in_array($structure, $this->perms->structure);
    }

    public function hasModule(int $module): bool
    {
        return in_array($module, $this->perms->modules);
    }

    protected function castAttribute($key, $value)
    {
        switch ($this->getCasts()[$key]) {
            case UserRolePermissions::class:
                return new UserRolePermissions(json_decode($value, true) ?: []);
            default:
                return parent::castAttribute($key, $value);
        }
    }

    public function newCollection(array $models = [])
    {
        return new UserRoleCollection($models);
    }
}