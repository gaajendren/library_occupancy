<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(){

       $users = User::all();

       return view('staff.account_management.index', compact('users'));

    }



    public function store(Request $request, string $id){

        $user = User::find($id);

        $rules =[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|string|max:255',  
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.', 
            'roles.required' => 'The role field is required.',
        ];
    
        
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect()->route('staff.edit.account', $user->id)->withErrors($validator)->withInput();
        }

        $input = $request->all();

        $input['role'] = $request->roles;

        $user->update($input);

        return redirect()->route('staff.account')->with('success', 'Successfuly Updated ! ');

    }

    public function add(Request $request){

        $input = $request->all();
        User::create($input);

        return redirect()->route('staff.account')->with('success', 'Successfuly Added ! ');
    }

    public function delete(string $id){

       $user = User::find($id);
       $user->delete();

       return redirect()->route('staff.account')->with('success', 'Successfuly Deleted ' . $user->name );
    }
}
