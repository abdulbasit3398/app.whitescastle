<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branches;
use App\User;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branches::orderBy('id', 'DESC')->get();

         
        return view('admin.branch.index')->with(compact('branches'));
    }

    public function store(Request $request)
    {
        if($request->branch_id)
        {
            $item = Branches::find($request->branch_id);
            $manager = User::find($item->user_id);
            $manager->name = $request->f_name;
            $manager->last_name = $request->l_name;
            $manager->email = $request->branch_email;
            $manager->phoneNo = $request->branch_phone;
            $manager->type = 'manager';
            if(!empty($request->password))
            {
                $manager->password = Hash::make($request->password);
            }
            $manager->save();
        }else{
            $manager = User::create([
                'name' => $request->f_name,
                'last_name' => $request->l_name,
                'email' => $request->branch_email,
                'phoneNo' => $request->branch_phone,
                'type' => 'manager',
                'password' => Hash::make($request->password),
            ]);
            $item = new Branches;
        }
        
        $item->branch_code = $request->branch_code;
        $item->branch_name = $request->branch_name;
        $item->branch_email = $request->branch_email;
        $item->branch_phone = $request->branch_phone;
        $item->branch_address = @addslashes($request->branch_address);
        $item->branch_latitude = $request->branch_latitude;
        $item->branch_longitude = $request->branch_longitude;
        $item->active = $request->status;
        if($request->branch_id)
        {}else{
            $item->user_id = $manager->id;
         }
        
        $item->save();

        return redirect()->back()->with('success', 'your message,here');   

         
    }
}
