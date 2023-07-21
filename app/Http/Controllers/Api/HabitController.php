<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habbit;
use App\Models\HabitCategory;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habbit::query()
        ->when(request("category_id"), function($query){
            return $query->where("habit_category_id", request("category_id"));
        })
        ->select("id", "name", "description", "image")
        ->orderBy("name")
        ->get();
        return response()
            ->json([
                "message"=> $habits->count()." records found.",
                "data" => $habits
            ]);
    }
    public function categories()
    {
        $categories = HabitCategory::get();
        return response()
            ->json([
                "message"=> $categories->count()." records found.",
                "data" => $categories
            ]);
    }
}
