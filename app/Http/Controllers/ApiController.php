<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function test(Request $request)
    {
        return response()->json(['message' => 'Success!']);
    }
}
