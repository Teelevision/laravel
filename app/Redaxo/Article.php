<?php

namespace App\Redaxo;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property int $clang_id
 * @property-read ArticleSlice[]|Collection $slices
 */
class Article extends Model
{
    public function slices()
    {
        return $this->hasMany(ArticleSlice::class);
    }

    public function invalidateCache()
    {
        \rex_article_cache::delete($this->id, $this->clang_id);
    }
}