<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class QuestionGroupController extends Controller
{
    public function index()
    {
        return view('pages.group-questions.groups');
    }
    public function add()
    {
        return view('pages.group-questions.add-group');
    }
    public function storeGroup(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required|max:255',
            'order' => 'required|numeric',
        ]);
        try {
            $group = QuestionGroup::create([
                'name' => $request->name,
                'order' => $request->order,
                'category' => $request->category
            ]);
            return redirect()->route('group-questions.index',['group_id' => $group->id]);
        } catch (Exception $e) {
            return response()->json(400);
        }
    }
}
