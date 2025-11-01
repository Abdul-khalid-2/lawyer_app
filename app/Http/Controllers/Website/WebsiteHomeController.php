<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class WebsiteHomeController extends Controller
{
    public function getSpecializations()
    {
        return response()->json(Specialization::select('id', 'name')->get());
    }
}
