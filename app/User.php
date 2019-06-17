<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
            ->withPivot('created_at');
    }

    public function scopeByCountry(Builder $builder, string $country): Builder
    {
        return $builder->whereHas('companies', function(Builder $builder) use($country) {
            return $builder->join('countries', 'country_id', '=', 'countries.id')
                ->where('countries.name', $country);
        });
    }
}
