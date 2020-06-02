<?php

namespace ILOGO\Logoinc\Models;

use Illuminate\Database\Eloquent\Model;
use ILOGO\Logoinc\Facades\Logoinc;
use ILOGO\Logoinc\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    protected $translatable = ['slug', 'name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

    public function posts()
    {
        return $this->hasMany(Logoinc::modelClass('Post'))
            ->published()
            ->orderBy('created_at', 'DESC');
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }
}
