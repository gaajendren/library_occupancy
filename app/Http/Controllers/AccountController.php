<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{
    public function index(){

       $users = User::orderBy('created_at', 'desc')->get();

       return view('staff.account_management.index', compact('users'));

    }



    public function store(Request $request, string $id){

        $user = User::find($id);

        $rules =[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'ic' => ['required',  'string', 'regex:/^((([02468][048]|[13579][26])(02)(29))|((\d{2})((0[1-9]|1[0-2])(0[1-9]|1\d|2[0-8])|(0[1|3-9]|1[0-2])(29|30)|(0[13578]|1[02])(31))))\-(\d{2})\-(\d{4})$/', 'min:14', 'max:14'],
            'contact' => ['required', 'string'],
            'address' => ['required', 'string'],
            'roles' => 'required|string|max:255',  
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'contact.required' => 'The contact field is required.', 
            'address.required' => 'The address field is required.', 
            'roles.required' => 'The role field is required.',
            'ic.regex' => 'The IC format is invalid.'
        ];
    
        
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect()->route('staff.account')->withErrors($validator)->withInput();
        }

        $input = $request->all();

        $input['role'] = $request->roles;

        if ($user->email != $input['email']) {
          
            $input['email_verified_at'] = null;
        }


        $user->update($input);

        return redirect()->route('staff.account')->with('success', 'Successfuly Updated ! ');

    }

    public function add(Request $request){

        $input = $request->all();
        $input['password'] = null;

        User::create($input);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return redirect()->route('staff.account')->with('success', 'Successfuly Added ! ');
        }else{
            return redirect()->route('staff.account')->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        } 
    }

    public function delete(string $id){

       $user = User::find($id);
       $user->delete();

       return redirect()->route('staff.account')->with('success', 'Successfuly Deleted ' . $user->name );
    }
}
