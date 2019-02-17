<?php

namespace App\Redaxo;

/**
 * @property int $id
 * @property-read Article|null $article
 * @property-read Module|null $module
 */
class ArticleSlice extends Model
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}