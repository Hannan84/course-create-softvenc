<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'modules.*.title' => 'required|string',
            'modules.*.contents.*.type' => 'required|string|in:text,image,video,link',
            'modules.*.contents.*.value' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $course = Course::create($request->only(['name', 'description', 'category']));

            foreach ($request->modules as $mod) {
                $module = $course->modules()->create(['title' => $mod['title']]);

                foreach ($mod['contents'] as $cont) {
                    $module->contents()->create($cont);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Course created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to save course.']);
        }
    }

}
