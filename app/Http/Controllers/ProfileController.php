<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    

    public function edit(Request $request): View
    {
        $path = $this->toRedirect();

        return view($path.'.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $path = $this->toRedirect();

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }


        if($request->has('ic')){
           $request->user()->ic = $request->ic;
           $request->user()->address = $request->address;
           $request->user()->contact = $request->contact;
        }

        $request->user()->save();

        return Redirect::route($path.'.profile.edit')->with('status', 'profile-updated')->with('success', 'Profile Updated Successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function toRedirect(){
        $role = auth()->user()->role;
        return $path = $role == 1 ?  'staff' : 'student'; 
    }
}
