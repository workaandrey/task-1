<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __invoke()
    {
        $country = 'Canada';

        $users = User::byCountry($country)
            ->with('companies', 'companies.country')
            ->get();

        //I know we can user laravel resource here but due to lack of time I did it this way
        return $users->map(function($user) {
            return [
                'user' => $user->name,
                'email' => $user->email,
                'companies' => $user->companies->map(function($company) {
                    return [
                        'name' => $company['name'],
                        'associated_at' => $company->pivot->created_at
                    ];
                })
            ];
        });
    }
}
