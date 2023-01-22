@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="container-full">
       <!-- Main content -->
    <section class="content">

        <!-- Basic Forms -->
        <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Add Blog Post</h4>            
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col">
                <form method="post" action="{{ route('blog-post-update')}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $blogpost->id }}">
                    <input type="hidden" name="old_image" value="{{ $blogpost->post_image}}">

                    <div class="row">
                    <div class="col-12">                   
                    
                       <div class="row">  <!-- start 2nd row -->
                          

                          <div class="col-sm-6">
                            <div class="form-group">
                                <h5>Post Title En <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="post_title_en" class="form-control" required="" value="{{ $blogpost->post_title_en }}">
                                    
                                    @error('post_title_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>  
                          </div> <!-- end col md 4 -->

                          <div class="col-sm-6">
                          <div class="form-group">
                                <h5>Post Title Hin <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="post_title_hin" class="form-control" required="" value="{{ $blogpost->post_title_hin }}">
                                    
                                    @error('post_title_hin')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>  
                          </div> <!-- end col md 4 -->

                       </div> <!-- end 2nd row -->


                       <div class="row">  <!-- start 6th row -->
                       <div class="col-sm-6">
                          <div class="form-group">
                                <h5>BlogCategory Select <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <select name="category_id"  class="form-control" required="">
                                        <option value="" selected disabled>Select BlogCategory</option>
                                        @foreach($blogcategory as $category)
                                        <option value="{{ $category->id}}" {{  $category->id == $blogpost->category_id ? 'selected': '' }}>{{ $category->blog_category_name_en }}</option>
                                        @endforeach
                                       
                                        
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                          </div> <!-- end col md 4 -->

                          <div class="col-sm-6">
                          <div class="form-group">
                                <h5>Post Main Image <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="file" name="post_image" class="form-control" onchange="mainThamUrl(this)">
                                    
                                    @error('post_image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <img src="" alt="" id="mainThmb">
                                </div>
                            </div> 
                          </div> <!-- end col md 4 -->

                          

                       </div> <!-- end 6th row -->

                       

                       <div class="row">  <!-- start 8th row -->
                          <div class="col-sm-6">
                          <div class="form-group">
                                <h5>Post Details English <span class="text-danger">*</span></h5>
                                <div class="controls">
                                 <textarea id="editor1" name="post_detail_en" rows="10" cols="80" required="">
                                 {!! $blogpost->post_detail_en !!}
						         </textarea>    
                                    
                                </div>
                            </div> 
                          </div> <!-- end col md 6 -->

                          <div class="col-sm-6">
                          <div class="form-group">
                                <h5>Post Details Hindi <span class="text-danger">*</span></h5>
                                <div class="controls">
                                 <textarea id="editor2" name="post_detail_hin" rows="10" cols="80" required="">
                                 {!! $blogpost->post_detail_hin !!}
						         </textarea>                                    
                                    
                                </div>
                            </div> 
                          </div> <!-- end col md 6 -->                          

                       </div> <!-- end 8th row -->    
                    
                    <!-- </div> -->
                    <!-- </div> -->
                    <hr>
                    
                   
                    <div class="text-xs-right">
                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Post">
                    </div>

                    </div>
                    </div>
                </form>

            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    </div>


    
    <script type="text/javascript" >
            function mainThamUrl(input){
                if(input.files && input.files[0]){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#mainThmb').attr('src',e.target.result).width(80).height(80);
                    };
                    reader.readAsDataURL(input.files[0]);

                }
            }
    </script>
   
  


@endsection