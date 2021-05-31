<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Prodect extends Model
{
    use HasFactory , HasTranslations , Sluggable , SoftDeletes, SearchableTrait;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public $translatable = ['title','slug','dec','price'];




    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'title'=> 10,
            'dec' => 10,
        ],
    ];




    //fix problem slug lng
    public   function sluggable(): array
    {
        return [
            'slug->en' => [
                'source' => 'titleen',
            ],
            'slug->ar' => [
                'source' => 'titlear',
            ],
            'slug->ca' => [
                'source' => 'titleca',
            ]
        ];
    }



    public function getTitleenAttribute()
    {
        return $this->getTranslation('title', 'en');
    }

    public function getTitlearAttribute()
    {
        return $this->getTranslation('title', 'ar');
    }

    public function getTitlecaAttribute()
    {
        return $this->getTranslation('title', 'ca');
    }
    //set type data in database is json
    protected function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    // Select Product with slug not Id
    public function getRouteKeyName()
    {
        return 'slug';
    }


}
