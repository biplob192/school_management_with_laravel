<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Group;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\SubjectTeacher;
use Illuminate\Database\QueryException;

class SubjectTeacherController extends Controller
{
    public function index()
    {
        try {
            $subjectTeachers = SubjectTeacher::with(['teacher.user', 'subject.class', 'section', 'group'])->latest()->paginate(20);
            return view('subject_teachers.index', compact('subjectTeachers'));
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $subjectTeachers = SubjectTeacher::all();

            return view('subject_teachers.create', array_merge(
                ['subjectTeachers' => $subjectTeachers],
                $this->getDropdownDataArray()
            ));

            // return view('subject_teachers.create');
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'subject_id'        => 'required|exists:subjects,id',
                'teacher_id'        => 'required|exists:teachers,id',
                'shift'             => 'required|string|in:Morning,Day,Evening',
                'section_id'        => $request->is_common_section ? 'nullable' : 'required|exists:sections,id',
                'group_id'          => 'nullable|exists:groups,id',
                'role'              => 'nullable|string|max:255',
                'is_common_section' => 'nullable|boolean',
            ]);


            $alreadyAssigned = SubjectTeacher::where('subject_id', $validated['subject_id'])
                ->where('teacher_id', $validated['teacher_id'])
                ->where('shift', $validated['shift'])
                ->where('section_id', $validated['section_id'])
                ->exists();

            if ($alreadyAssigned) {
                return back()->withErrors([
                    'error' => 'This subject is already assigned to this teacher in the same shift and section.'
                ])->withInput();
            }

            SubjectTeacher::create($validated);

            return redirect()->route('subject_teachers.index')->with('success', 'Subject Teacher assigned successfully.');
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $subjectTeacher = SubjectTeacher::with(['teacher', 'subject'])->findOrFail($id);
            return view('subject_teachers.show', compact('subjectTeacher'));
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $subjectTeacher = SubjectTeacher::findOrFail($id);
            // return view('subject_teachers.edit', compact('subjectTeacher'));

            return view('subject_teachers.edit', array_merge(
                ['subjectTeacher' => $subjectTeacher],
                $this->getDropdownDataArray()
            ));
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'subject_id'        => 'required|exists:subjects,id',
                'teacher_id'        => 'required|exists:teachers,id',
                'shift'             => 'required|string|in:Morning,Day,Evening',
                'section_id'        => 'nullable|exists:sections,id',
                'group_id'          => 'nullable|exists:groups,id',
                'role'              => 'nullable|string|max:255',
                'is_common_section' => 'nullable|boolean',
            ]);

            $subjectTeacher = SubjectTeacher::findOrFail($id);

            // Check for duplicate assignment excluding the current one
            $alreadyAssigned = SubjectTeacher::where('subject_id', $validated['subject_id'])
                ->where('teacher_id', $validated['teacher_id'])
                ->where('shift', $validated['shift'])
                ->where('section_id', $validated['section_id'])
                ->where('id', '!=', $id)
                ->exists();

            if ($alreadyAssigned) {
                return back()->withErrors([
                    'error' => 'This subject is already assigned to this teacher in the same shift and section.'
                ])->withInput();
            }

            $subjectTeacher->update($validated);

            return redirect()->route('subject_teachers.index')->with('success', 'Subject Teacher updated successfully.');
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $subjectTeacher = SubjectTeacher::findOrFail($id);
            $subjectTeacher->delete();

            return redirect()->route('subject_teachers.index')->with('success', 'Subject Teacher deleted successfully.');
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function getDropdownData()
    {
        return [
            'subjects' => Subject::pluck('name', 'id'),
            'teachers' => Teacher::with('user')->get()->pluck('user.name', 'id'),
            'sections' => Section::pluck('name', 'id'),
            'groups'   => Group::pluck('name', 'id'),
        ];
    }


    private function getDropdownDataArray()
    {
        return [
            'classes'  => SchoolClass::orderBy('id', 'asc')->pluck('name', 'id')->toArray(),
            'groups'   => Group::pluck('name', 'id')->toArray(),
            'sections' => Section::pluck('name', 'id')->toArray(),
            'subjects' => Subject::pluck('name', 'id')->toArray(),
            'teachers' => Teacher::with('user')->get()->pluck('user.name', 'id')->toArray(),
        ];
    }

    public function getGroupsByClass($id)
    {
        $class = SchoolClass::findOrFail($id);
        $groups = $class->groups()
            ->select('groups.id as id', 'groups.name')
            ->pluck('groups.name', 'id');

        return response()->json(['groups' => $groups]);
    }

    public function getSectionsByClass($id)
    {
        $class = SchoolClass::findOrFail($id);
        $sections = $class->sections()
            ->select('sections.id as id', 'sections.name')
            ->pluck('sections.name', 'id');

        return response()->json(['sections' => $sections]);
    }

    public function getSubjectsByClass($classId)
    {
        $subjects = Subject::where('class_id', $classId)
            ->select('id', 'name')
            ->pluck('name', 'id');

        return response()->json(['subjects' => $subjects]);
    }



    // public function getGroupSections($classId, $groupId)
    // {
    //     $class = SchoolClass::findOrFail($classId);
    //     $sections = $class->sections()
    //         ->whereHas('classes', fn($q) => $q->where('class_id', $classId))
    //         ->pluck('name', 'id');

    //     return response()->json($sections);
    // }

    public function getGroupSections($classId, $groupId)
    {
        $class = SchoolClass::findOrFail($classId);
        $sections = $class->sections()
            ->whereHas('classes', fn($q) => $q->where('class_id', $classId))
            ->select('sections.id', 'sections.name')
            ->pluck('sections.name', 'sections.id');

        return response()->json(['sections' => $sections]);
    }

    public function getSubjects($sectionId)
    {
        $subjects = Subject::where('section_id', $sectionId)->pluck('name', 'id');
        return response()->json($subjects);
    }
}
