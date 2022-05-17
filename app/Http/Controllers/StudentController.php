<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {

        $students = Student::all();
        if ($request->ajax()) {
            return
                DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'"
                                data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';
                    $btn.= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'"
                                data-original-title="Delete" class="edit btn btn-danger btn-sm deleteStudent">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('students', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $student = Student::updateOrCreate(

            [
                ['id' => request('student_id')],
                ['email' =>  request('email')],
                ['name' => request('name')]
            ]
        );
            $student->save();
            return response ()->json(['success'=>'Student Added Successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $students=Student::find ($id);
        return response()->json($students);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        Student:: find($id) ->delete();
        return response() ->json(['success'=>'Student Deleted Successfully' ]);
    }
}
