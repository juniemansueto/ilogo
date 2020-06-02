<?php

namespace ILOGO\Logoinc\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ILOGO\Logoinc\Facades\Logoinc;

class LogoincUserController extends LogoincBaseController
{
    public function profile(Request $request)
    {
        $route = '';
        $dataType = Logoinc::model('DataType')->where('model_name', Auth::guard(app('LogoincGuard'))->getProvider()->getModel())->first();
        if (!$dataType && app('LogoincGuard') == 'web') {
            $route = route('logoinc.users.edit', Auth::user()->getKey());
        } elseif ($dataType) {
            $route = route('logoinc.'.$dataType->slug.'.edit', Auth::user()->getKey());
        }

        return Logoinc::view('logoinc::profile', compact('route'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        if (Auth::user()->getKey() == $id) {
            $request->merge([
                'role_id'                              => Auth::user()->role_id,
                'user_belongstomany_role_relationship' => Auth::user()->roles->pluck('id')->toArray(),
            ]);
        }

        return parent::update($request, $id);
    }
}
