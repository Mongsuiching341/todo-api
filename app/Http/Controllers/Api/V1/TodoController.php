<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->header('user_id');

        $todos = Todo::where('user_id', $user_id)->get();

        return TodoResource::collection($todos);
    }

    public function store(Request $request)
    {
        $user_id = $request->header('user_id');
        $todoName = $request->input('name');
        $todo = $request->input('todo');

        //create todo

        $todo =  Todo::create([
            'user_id' => $user_id,
            'name' => $todoName,
            'todo' => $todo,
        ]);

        if ($todo) {
            return response()->json(['msg' => 'todo created', 'status' => 'success']);
        } else {
            return response()->json(['msg' => 'could not create todo', 'status' => 'failed']);
        }
    }

    public function edit(Request $request, Todo $todo)
    {
        $todoName = $request->input('name');
        $todoContent = $request->input('todo');

        $update = $todo->update([
            'name' => $todoName,
            'todo' => $todoContent,
        ]);

        if ($update) {
            return response('todo Updated successfully');
        } else {
            return response('something went wrong');
        }
    }

    public function destroy(Todo $todo)
    {

        $delete =  $todo->delete();

        if ($delete) {
            return response('todo deleted');
        } else {
            return response('something went wrong');
        }
    }
}
