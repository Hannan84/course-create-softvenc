<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
 public function index()
 {
  $courses = Course::with('modules.contents')->get();
//   dd($courses);
  return view('index', compact('courses'));
 }

 public function create()
 {
  return view('create');
 }

 public function store(Request $request)
 {
  $request->validate([
   'name'                       => 'required|string',
   'category'                   => 'required|string',
   'modules.*.title'            => 'required|string',
   'modules.*.contents'         => 'required|array|min:1',
   'modules.*.contents.*.type'  => 'required|string|in:text,image,video,link',
   'modules.*.contents.*.value' => 'required|string',
  ]);
//   dd($request->all());
  DB::beginTransaction();
  try {
   $course = Course::create([
    'name'        => $request->name,
    'description' => $request->description,
    'category'    => $request->category,
   ]);

   foreach ($request->modules as $mod) {
    $module = $course->modules()->create(['title' => $mod['title']]);

    if (isset($mod['contents']) && is_array($mod['contents'])) {
     foreach ($mod['contents'] as $content) {
      $module->contents()->create([
       'type'  => $content['type'],
       'value' => $content['value'],
      ]);
     }
    }
   }

   DB::commit();
   return redirect()->back()->with('success', 'Course created successfully.');
  } catch (\Throwable $e) {
   DB::rollBack();
//    dd($e->getMessage());
   return redirect()->back()->withErrors(['error' => 'Failed to save course.']);
  }
 }

}
