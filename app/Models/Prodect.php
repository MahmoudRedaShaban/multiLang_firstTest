<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Prodect extends Model
{
    use HasFactory , HasTranslations ,HasTranslatableSlug , SoftDeletes, SearchableTrait;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public $translatable = ['title','slug','dec','price'];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

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

    /**
     * @overrid Method
     * for Slug
    */
    protected function generateNonUniqueSlug(): string
    {
        $slugField = $this->slugOptions->slugField;

        if ($this->hasCustomSlugBeenUsed() && ! empty($this->$slugField)) {
            return $this->$slugField;
        }
        return MySlugHelper::slug($this->getSlugSourceString());
        // return Str::slug($this->getSlugSourceString(), $this->slugOptions->slugSeparator, $this->slugOptions->slugLanguage);
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
