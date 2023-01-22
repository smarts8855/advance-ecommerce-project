<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPostCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class HomeBlogController extends Controller
{
    public function HomeBlog(){
        $blogCategory = BlogPostCategory::latest()->get();
        $blogpost = BlogPost::latest()->get();
        return view('frontend.blog.blog_list',compact('blogCategory','blogpost'));

    } // End Method

    public function DetailsBlogPost($id){
        $blogCategory = BlogPostCategory::latest()->get();
        $blogpost = BlogPost::findOrFail($id);
        return view('frontend.blog.blog_details',compact('blogpost','blogCategory'));
    } // End Method

    public function HomeBlogCatPost($category_id){
        $blogCategory = BlogPostCategory::latest()->get();
        $blogpost = BlogPost::where('category_id',$category_id)->orderBy('id','DESC')->get();
        return view('frontend.blog.blog_cat_list',compact('blogCategory','blogpost'));
    }
}
