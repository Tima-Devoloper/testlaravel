<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** 
    * @param Request $request
    */
    public function registration(Request $request)
    {
        $validatorRules = [
            'email'     => 'required|unique:users,email',
            'password'  => 'required|'
        ];
        $validatorMessages = [
            'email.unique'      =>  'Email существует!'
        ];

        $validator = Validator::make($request->all(), $validatorRules,$validatorMessages);

        if ($validator->fails()) {
            return redirect('/registration')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect()->route('main');
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validatorRules = [
            'email' => ['required', 'email','exists:users,email'],
            'password' => ['required'],
        ];

        $validatorMessages = [
            'email.exists'      =>  'Email не существует!'
        ];

        $credentials = $request->validate($validatorRules,$validatorMessages);
        if (Auth::attempt($credentials)) {

            return redirect()->route('main');
        }

        return back()->withError([
            'error' =>  'Не верный email или пароль'
        ]);
    }
}
