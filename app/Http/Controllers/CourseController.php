<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Product::where('category', 'course')->get();
        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Product::where('id', $id)
                        ->where('category', 'course')
                        ->firstOrFail();
        return view('courses.show', compact('course'));
    }

    public function myCourses()
    {
        $user = Auth::user();
        $myCourses = Product::whereHas('orders', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'paid');
        })
        ->where('category', 'course')
        ->get();

        return view('courses.my-courses', compact('myCourses'));
    }
}
