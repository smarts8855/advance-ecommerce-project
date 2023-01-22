<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function SliderView(){
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_view',compact('sliders'));

    }// End Method

    public function SliderStore(Request $request){

        $request->validate([
            'slider_img' => 'required',
            
        ],[
            'slider_img.required' => 'Plz Select One Image',            
        ]);

        $image = $request->file('slider_img');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,           
            'slider_img' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method

    public function SliderEdit($id){
        $slider = Slider::findOrFail($id);
        return view('backend.slider.slider_edit',compact('slider'));
    }  // End Method


    public function SliderUpdate(Request $request){
        $slider_id = $request->id;
        $old_img = $request->old_image;

        if($request->file('slider_img')){

            unlink($old_img);
            $image = $request->file('slider_img');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'description' => $request->description,                
                'slider_img' => $save_url,
            ]);

            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('manage-slider')->with($notification);
        }else{

            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'description' => $request->description,                
                
            ]);

            $notification = array(
                'message' => 'Slider Updated Without Image Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('manage-slider')->with($notification);

        } // end else

    } // End Method

    public function SliderDelete($id){
        $slider = Slider::findOrFail($id);
        $img = $slider->slider_img;
        unlink($img);

        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider  Deleted Successfully',  
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }//End Method

    public function SliderInactive($id){
        Slider::findOrFail($id)->update(['status' => 0]);
        $notification = array(
            'message' => 'Slider Inactive',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method

    public function SliderActive($id){
        Slider::findOrFail($id)->update(['status' => 1]);
        $notification = array(
            'message' => 'Slider Active',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method
}
