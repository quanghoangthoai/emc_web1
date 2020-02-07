<?php

namespace Modules\Banner\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load model
use Modules\Banner\Models\Banner;

class BannerController extends Controller
{
    public function getIndex(Request $request)
    {
        return 'Module "Banner" created!';
    }
}