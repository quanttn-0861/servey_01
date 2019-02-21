<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use File;
use App\Notifications\ResetPasswordNotification;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'gender',
        'phone',
        'address',
        'image',
        'status',
        'level',
        'background',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['gender_custom', 'level_custom', 'status_custom'];

    public function likes()
    {
        return $this->hasMany(Like::class)->withTrashed();
    }

    public function results()
    {
        return $this->hasMany(Result::class)->withTrashed();
    }

    public function members()
    {
        return $this->belongsToMany(Survey::class, 'members', 'user_id', 'survey_id')
            ->withTrashed()
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value ?: config('users.avatar_default');
    }

    public function getImagePathAttribute()
    {
        if (!Storage::disk('local')->exists($this->attributes['image']) || empty($this->attributes['image'])) {
            return config('settings.image_user_default');
        }

        return Storage::url($this->attributes['image']);
    }

    public function getBackgroundAttribute()
    {
        if (!File::exists($this->attributes['background']) || empty($this->attributes['background'])) {
            return config('settings.cover-profile.default');
        }

        return $this->attributes['background'];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setLevelAttribute($value)
    {
        $this->attributes['level'] = $value ?: config('users.level.user');
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value ?: config('users.status.user');
    }

    public function reciveResults()
    {
        return $this->hasMany(Result::class, 'reciver_id')->withTrashed();
    }

    public function sendResults()
    {
        return $this->hasMany(Result::class, 'sender_id')->withTrashed();
    }

    public function reciveSurveys()
    {
        return $this->hasMany(Invite::class, 'reciver_id')->withTrashed();
    }

    public function sendSurveys()
    {
        return $this->hasMany(Invite::class, 'sender_id')->withTrashed();
    }

    public function isAdmin()
    {
        return $this->level == config('users.level.admin');
    }

    public function isActive()
    {
        return $this->status == config('users.status.active');
    }

    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = $value ?: null;
    }

    public function requestAdmin()
    {
        return $this->hasMany(Request::class, 'admin_id');
    }

    public function requestMember()
    {
        return $this->hasOne(Request::class, 'member_id');
    }

    public function getPartNameAttribute()
    {
        return str_limit($this->attributes['name'], config('users.name_length_default'));
    }

    public function temps()
    {
        return $this->hasMany(Temp::class);
    }

    public function scopeOfTemp($query, $id)
    {
       return $query
        ->join('temps', 'users.id', 'temps.user_id')
        ->where('temps.user_id', $this->id)
        ->where('survey_id', $id);
    }

    public function socialAccounts()
    {
        return $this->hasOne(SocialAccount::class);
    }

    public function getBirthdayAttribute()
    {
        return $this->attributes['birthday']
            ? Carbon::parse($this->attributes['birthday'])->format(trans('lang.date_format')) : null;
    }

    public function getGenderCustomAttribute()
    {
        if ($this->gender == config('users.gender.male')) {
            return trans('profile.male');
        }

        if ($this->gender == config('users.gender.female')) {
            return trans('profile.female');
        }

        if ($this->gender == config('users.gender.other_gender')) {
            return trans('profile.other');
        }

        return null;
    }

    public function getLevelCustomAttribute()
    {
        return $this->level == config('users.level.admin') ? trans('lang.admin') : trans('lang.user');
    }

    public function getStatusCustomAttribute()
    {
        return $this->status == config('users.status.active') ? trans('lang.active') : trans('lang.block');
    }

    public function checkLoginWsm()
    {
        return $this->socialAccounts()->where('provider', SocialAccount::PROVIDER_FRAMGIA)->first();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
