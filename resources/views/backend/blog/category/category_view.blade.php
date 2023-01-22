@extends('admin.admin_master')
@section('admin')

 <!-- Content Wrapper. Contains page content -->
 
    <div class="container-full">  

    <!-- Main content -->
    <section class="content">
        <div class="row">      

        <div class="col-md-8 col-sm-8">

            <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Blog Category List <span class="badge badge-pill badge-danger">{{ count($blogcategory) }}</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>                            
                            <th>Blog Category En</th>
                            <th>Blog Category Hin</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogcategory as $item)
                        <tr>                            
                            <td>{{ $item->blog_category_name_en }}</td>
                            <td>{{ $item->blog_category_name_hin }}</td>
                            <td>                            
                                <a href="{{ route('blog.category.edit',$item->id) }}" class="btn btn-info" title="Edit Brand"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('blog.category.delete',$item->id) }}" class="btn btn-danger" id="delete"><i class="fa fa-trash" title="Delete Brand"></i></a>
                            </td>
                            
                        </tr>
                        @endforeach
                       
                    </tbody>
                   
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->

                    
        </div>
        <!-- /.col -->


<!-- ------------------ Add Blog Category Page  ------------------ -->

        <div class="col-md-4 col-sm-4">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"> Add Blog Category</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                

            <form method="post" action="{{ route('blogcategory.store') }}" >
                    @csrf          
                        
                    
                        <div class="form-group">
                            <h5>Blog Category English </h5>
                            <div class="controls">
                                <input  type="text" name="blog_category_name_en" class="form-control"  >
                                @error('blog_category_name_en')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Blog Category Hindi </h5>
                            <div class="controls">
                                <input  type="text" name="blog_category_name_hin" class="form-control"  >
                                @error('blog_category_name_hin')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    
                    <div class="text-xs-right">
                        <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add New">
                    </div>
           </form>


            </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

                
        </div>
        <!-- /.col -->


        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    
    </div>


@endsection