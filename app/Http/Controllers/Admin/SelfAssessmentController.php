<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SelfAssessmentResponse;
use Illuminate\Http\Request;

class SelfAssessmentController extends Controller
{
    public function show(SelfAssessmentResponse $response)
    {
        return view("users.self-assessment.show", compact("response"));
    }
    
}
