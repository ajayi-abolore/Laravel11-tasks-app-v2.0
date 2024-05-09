<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //

    public function create(Request $request): JsonResponse
    {

        $request->validate([
            'user_id'       => 'required',
            'title'         => 'required',
            'description'   => 'required',
            'due_date'      => 'required',
            'due_time'      => 'required',
            'file'          => 'nullable|mimes:pdf,xlx,csv,jpg,jpeg,png,gif|max:2048'
        ]);

        $userID     = $request->user_id;
        $name       = Auth::user()->name;
        if ($request->has('file')) {
            $fileName   = time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);
        }


        try {

            $Create                     = new Task();
            $Create->assign_to          = $userID;
            $Create->title              = $request->title;
            $Create->description        = $request->description;
            $Create->due_date           = $request->due_date;
            $Create->due_time           = $request->due_time;
            $Create->file               = $request->file;
            $Create->save();

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Successfully Created Booking Record !!!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e
            ]);
        }
    }

    public function read(): JsonResponse
    {
        try {

            $tasks  = Task::latest()->get();

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'data'          => $tasks,
                'message'       => 'Success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e
            ]);
        }
    }

    public function getbyId(Request $request): JsonResponse
    {
        try {
            $id = $request->route('id');
            $tasks  = Task::whereId($id)->latest()->get();
            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Success',
                'data'          => $tasks,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e
            ]);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'title'         => 'required',
                'description'   => 'required'
            ]);
            $id     = $request->route('id');
            Task::whereId($id)
                ->update([
                    'title'         => $request->title,
                    'description'   => $request->description,
                ]);

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Updated Successfully !!!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e
            ]);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        try {

            $id = $request->route('id');
            Task::whereId($id)->delete();
            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Task Deleted !!!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e
            ]);
        }
    }
}
