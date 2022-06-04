<?php

use Ll\DcatConfig\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('llconfig', Controllers\DcatConfigController::class);
