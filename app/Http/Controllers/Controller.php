<?php

namespace App\Http\Controllers;

use App\Traits\AddsNavigation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AddsNavigation;

    public function __construct()
    {
        $this->addNavigation();
    }
}
