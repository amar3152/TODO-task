<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodosController extends Controller
{
    public function index(){
      $todos = Todo::all();
        return view('todos.index')->with('todos',$todos);
    }

    public function show(string $id){
      $todos = Todo::find($id);

        return view('todos.show')->with('todos',$todos);
    }

    public function create(){
        return view('todos.create');
    }

    public function store(Request $request){
        $this->validate(request(),[
            'name'=>'required|min:6|max:250',
            'description'=> 'required'
        ]);
        //Create a new todo using the
        $data = $request->all();
        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;

        $todo->save();

        session()->flash('success', 'Todo created successfully.');
        return redirect('/todos');

    }

    public function edit(Todo $todo)
    {
      return view('todos.edit')->with('todo', $todo);
    }

    public function update(Todo $todo)
    {
      $this->validate(request(), [
        'name' => 'required|min:6|max:12',
        'description' => 'required'
      ]);

      $data = request()->all();

      $todo->name = $data['name'];
      $todo->description = $data['description'];

      $todo->save();

      session()->flash('success', 'Todo updated successfully.');

      return redirect('/todos');
    }

    public function destroy(Todo $todo)
    {
      $todo->delete();

      session()->flash('success', 'Todo deleted successfully.');

      return redirect('/todos');
    }

    public function complete(Todo $todo)
    {
      $todo->completed = true;
      $todo->save();

      session()->flash('success', 'Todo completed successfully.');

      return redirect('/todos');
    }
}
