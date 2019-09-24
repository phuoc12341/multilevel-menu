<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
    ];

    /**
     * Get the post's menu.
     */
    public function menu()
    {
        return $this->morphOne(Menu::class, 'menuable');
    }

    /**
     * Transform value name into post's slug.
     *
     * @param  string  $value
     * @return string  $value
     */
    public function transformNameToSlug($value)
    {
        $slug = Str::slug($value, '-');

        return sprintf("%s-post%u.html", $slug, $this->id);
    }

    /**
     * Set the post's slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->transformNameToSlug($value) ;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
