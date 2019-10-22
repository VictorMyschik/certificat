<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\MrMessageHelper;
use App\Http\Controllers\MrBaseHelper;
use App\Models\MrSubscription;
use Illuminate\Http\Request;

class MrAdminSubscription extends Controller
{
    public function index()
    {
        $out = array();
        $out['emails'] = MrSubscription::GetAll();


        return View('Admin.mir_admin_subscription')->with($out);
    }

    public function UnSubscription(int $id)
    {
        $sub = MrSubscription::loadBy($id);
        if ($sub) {
            $sub->mr_delete();
        }

        MrMessageHelper::SetMessage(MrMessageHelper::KIND_SUCCESS,
            'Email: '.$sub->getEmail().' успешно отписн от рассылки');

        return back();
    }

    public function NewSubscription(Request $request)
    {
        $email = $request->get('email');
        $regex = '/\S+@\S+\.\S+/';
        if (preg_match($regex, $email)) {
            MrSubscription::Subscription($email);
        }

        return back();
    }
}