<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    /**
     * create check
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatorRules = [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:7120',
            'type'      => 'required|in:regular,prize',
            'token'     => 'required|exists:users,remember_token'
        ];
        $validatorMessages = [
        ];

        $validator = Validator::make($request->all(), $validatorRules,$validatorMessages);

        if ($validator->fails()) {
            return response()->json(['error' => 'Что-то пошло не так'],400);
        }

        if( 
            $request->type == 'regular' &&
            ( Carbon::now()->isoFormat('Oh') % 2 ) == 1
        ) {
            $status = 'accepted';
        } else if(
            $request->type == 'prize' &&
            ( Carbon::now()->isoFormat('Oh') % 2 ) == 0
        ) {
            $status = 'accepted';
            $code   = Str::random(8);
        } else {
            $status = 'rejected';
        }

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        //move image
        request()->image->move( public_path('images'), $imageName );

        $user = User::where('remember_token' , $request->token)->first();

        $check = new Check;
        $check->user_id = $user->id;
        $check->type = $request->type;
        $check->photo_url = 'images/' . $imageName;
        $check->code = $code ?? null;
        $check->status = $status;
        $check->save();

        if( $status == 'rejected' ) {
            return response()->json( ['error' => 'В это время чеки с этим типом не одобряются'] , 400 );
        }
        return response()->json( $check , 200 );
    }
}
