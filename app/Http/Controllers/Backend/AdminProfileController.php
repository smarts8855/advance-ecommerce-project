<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminProfileController extends Controller
{
    public function AdminProfile(){
        $id = Auth::user()->id;
       $admindata = Admin::find($id);
       return view('admin.admin_profile_view',compact('admindata'));
    }// End Method

    public function AdminProfileEdit(){
        $id = Auth::user()->id;
        $editdata = Admin::find($id);
       return view('admin.admin_profile_edit',compact('editdata'));
    } // End Method

    public function AdminProfileStore(Request $request){
        $admin_id = $request->id;
        $old_img = $request->old_image;

        if($request->file('profile_photo_path')){

            unlink($old_img);
            $image = $request->file('profile_photo_path');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(225,225)->save('upload/admin_images/'.$name_gen);
            $save_url = 'upload/admin_images/'.$name_gen;

            Admin::findOrFail($admin_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'profile_photo_path' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Admin User Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('dashboard')->with($notification);
        }else{

            Admin::findOrFail($admin_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Admin Profile Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('dashboard')->with($notification);

        } // end else
    } // End Method

    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    } // End Method

    public function AdminUpdateChangePassword(Request $request){
        $validateDate = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
           ]);

           $hashedPassword = Auth::user()->password;
           if(Hash::check($request->oldpassword,$hashedPassword)){
            $admin = Admin::find(Auth::id());
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();
            return redirect()->route('admin.logout');
           }else{
            return redirect()->back();
           }

    } // End Method
    
    public function AllUsers(){
        $users = User::latest()->get();
        return view('backend.user.all_user',compact('users'));
    }
}
