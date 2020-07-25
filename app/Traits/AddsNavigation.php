<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

trait AddsNavigation
{
    public function addNavigation()
    {
        $this->middleware(function ($request, $next) {
            $nav = [
                'left' => [
                    [
                        'url' => route('products.index'),
                        'name' => 'All items'
                    ]
                ],

                'right' => [
                    [
                        'url' => route('login'),
                        'name' => 'Login',
                    ]
                ]

            ];

            if (Auth::user()) {
                $nav['left'] = [
                    [
                        'url' => route('products.index'),
                        'name' => 'All Products'
                    ],
                    [
                        'url' => route('products.create'),
                        'name' => 'Add a product'
                    ]
                ];
                $nav['right']['dropdown'][] = [
                    'url' => route('products.index'),
                    'name' => 'Trash'
                ];
                $nav['right']['dropdown'][] = [
                    'url' => route('logout'),
                    'name' => 'Logout'
                ];
            };

            if (Route::has('register')) {
                $nav['register'][] =
                    [
                        'url' => route('register'),
                        'name' => 'Register'
                    ];
            }

            View::share('nav', $nav);
            return $next($request);
        });
    }
}
