<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'survey_id',
        'order',
        'update',
        'redirect_id',
    ];

    protected $dates = ['deleted_at'];

    public function settings()
    {
        return $this->morphMany(Setting::class, 'settingable')->withTrashed();
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->withTrashed()->orderBy('order');
    }

    public function withTrashedQuestions()
    {
        return $this->hasMany(Question::class)->withTrashed()->orderBy('order');
    }

    public function getLimitTitleAttribute()
    {
        return ucfirst(str_limit($this->attributes['title'], config('settings.title_length_default')));
    }

    public function getCustomDescriptionAttribute()
    {
        return ucfirst($this->attributes['description']);
    }

    public function showTitleTooltip()
    {
        return strlen($this->attributes['title']) >= config('settings.title_length_default')
            ? $this->attributes['title']
            : '';
    }
}
