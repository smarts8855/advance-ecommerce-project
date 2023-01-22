<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPostCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function BlogCategory(){
        $blogcategory = BlogPostCategory::latest()->get();
        return view('backend.blog.category.category_view',compact('blogcategory'));
    } // End Method

    public function BlogCategoryStore(Request $request){

        $request->validate([
            'blog_category_name_en' => 'required',
            'blog_category_name_hin' => 'required',           
        ],[
            'blog_category_name_en.required' => 'Input BlogCategory English Name',
            'blog_category_name_hin.required' => 'Input BlogCategory Hindi Name',
        ]);
        

        BlogPostCategory::insert([
            'blog_category_name_en' => $request->blog_category_name_en,
            'blog_category_name_hin' => $request->blog_category_name_hin,
            'blog_category_slug_eng' => strtolower(str_replace(' ', '-',$request->blog_category_name_en)),
            'blog_category_slug_hin' => str_replace(' ', '-',$request->blog_category_name_hin),
            'created_at' => Carbon::now(),
            
            
        ]);

        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method

    public function BlogCategoryEdit($id){
        $blogcategory = BlogPostCategory::findOrFail($id);
        return view('backend.blog.category.category_edit',compact('blogcategory'));
    } // End Method

    public function BlogCategoryUpdate(Request $request){

        $blogcar_id = $request->id;

        BlogPostCategory::findOrFail($blogcar_id)->update([
            'blog_category_name_en' => $request->blog_category_name_en,
            'blog_category_name_hin' => $request->blog_category_name_hin,
            'blog_category_slug_eng' => strtolower(str_replace(' ', '-',$request->blog_category_name_en)),
            'blog_category_slug_hin' => str_replace(' ', '-',$request->blog_category_name_hin),
            'created_at' => Carbon::now(),
            
            
        ]);

        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('blog-category')->with($notification);

    } // End Method

    public function BlogCategoryDelete($id){
        BlogPostCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Methd


    /////////////////////// Blog Post All Methods //////////////////

    public function ListBlogPost(){
        $blogpost = BlogPost::with('category')->latest()->get();
        return view('backend.blog.post.post_list',compact('blogpost'));
    } // End Method

    public function AddBlogPost(){
        $blogcategory = BlogPostCategory::latest()->get();
        $blogpost = BlogPost::latest()->get();
        return view('backend.blog.post.post_add',compact('blogpost','blogcategory'));

    } // End Method

    public function BlogPostStore(Request $request){

        $request->validate([
            'post_title_en' => 'required',
            'post_title_hin' => 'required',
            'post_image' => 'required',
        ],[
            'post_title_en.required' => 'Input Post Title English Name',
            'post_title_hin.required' => 'Input Post Title Hindi Name',
        ]);

        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(780,433)->save('upload/post/'.$name_gen);
        $save_url = 'upload/post/'.$name_gen;

        BlogPost::insert([
            'category_id' => $request->category_id,
            'post_title_en' => $request->post_title_en,
            'post_title_hin' => $request->post_title_hin,                       
            'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
            'post_slug_hin' => str_replace(' ', '-',$request->post_title_hin),
            'post_image' => $save_url,
            'post_detail_en' => $request->post_detail_en,
            'post_detail_hin' => $request->post_detail_hin,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('list.post')->with($notification);

    } // End Method

    public function BlogPostEdit($id){
        $blogcategory = BlogPostCategory::latest()->get();
        $blogpost = BlogPost::findOrFail($id);        
        return view('backend.blog.post.post_edit',compact('blogpost','blogcategory'));

    } // End Method

    public function BlogPostUpdate(Request $request){
        $blogpost_id = $request->id;
        $old_img = $request->old_image;

        if($request->file('post_image')){

            unlink($old_img);
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(780,433)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;

            BlogPost::findOrFail($blogpost_id)->update([
                'category_id' => $request->category_id,
                'post_title_en' => $request->post_title_en,
                'post_title_hin' => $request->post_title_hin,                       
                'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
                'post_slug_hin' => str_replace(' ', '-',$request->post_title_hin),
                'post_image' => $save_url,
                'post_detail_en' => $request->post_detail_en,
                'post_detail_hin' => $request->post_detail_hin,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('list.post')->with($notification);
        }else{

            BlogPost::findOrFail($blogpost_id)->update([
                'category_id' => $request->category_id,
                'post_title_en' => $request->post_title_en,
                'post_title_hin' => $request->post_title_hin,                       
                'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
                'post_slug_hin' => str_replace(' ', '-',$request->post_title_hin),                
                'post_detail_en' => $request->post_detail_en,
                'post_detail_hin' => $request->post_detail_hin,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('list.post')->with($notification);

        } // end else

    } // End Method

    public function BlogPostDelete($id){
        $blogpost = BlogPost::findOrFail($id);
        $img = $blogpost->post_image;
        unlink($img);

        BlogPost::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Post  Deleted Successfully',  
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }//End Method
}
