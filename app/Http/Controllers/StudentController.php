<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function marking(Request $request)
    {
        try {
            // $students = Student::where('is_active', true)->where('class_id', 2)->latest()->limit(12)->get();
            $students = User::whereHas('student', function ($query) {
                $query->where('class_id', 2);
            })
                ->with(['student' => function ($query) {
                    $query->where('class_id', 2);
                }])
                ->get();

            return view('students.marking', [
                'students' => $students
            ]);

            // $formatedData = $this->userService->formateDataForIndexWithPaginate($request);
            // $response = $this->userRepository->indexWithPaginate($formatedData);

            // return view('users.index', [
            //     'users' => $response,
            //     'perPage' => $formatedData->perPage,
            //     'search' => $formatedData->search,
            //     'specialSearch' => $formatedData->specialSearch,
            //     'customConditions' => $formatedData->customConditions,
            // ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Unable to show the users. ' . $e->getMessage()]);
        }
    }
}
