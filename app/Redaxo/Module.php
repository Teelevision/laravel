<?php

namespace App\Redaxo;

use Illuminate\Database\Eloquent\Collection;
use App\Support\ModuleHelper;

/**
 * @property int $id
 * @property string $name
 * @property string $input
 * @property string $output
 * @property-read ArticleSlice[]|Collection $slices
 * @property-read Article[]|Collection $articles
 */
class Module extends Model
{

    protected $fillable = ['name', 'input', 'output'];


    public function slices()
    {
        return $this->hasMany(ArticleSlice::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, (new ArticleSlice())->getTable());
    }

    public function invalidateCache()
    {
        $this->articles->map(function (Article $article) {
            $article->invalidateCache();
        });
    }
}