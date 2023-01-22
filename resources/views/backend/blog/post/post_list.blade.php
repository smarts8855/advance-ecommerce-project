@extends('admin.admin_master')
@section('admin')

 <!-- Content Wrapper. Contains page content -->
 
    <div class="container-full">  

    <!-- Main content -->
    <section class="content">
        <div class="row">      

        <div class="col-md-12 col-sm-12">

            <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Blog Post List <span class="badge badge-pill badge-danger">{{ count($blogpost) }}</span></h3>
                <a href="{{ route('add.post') }}" class="btn btn-success float-right" >Add Post</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>                            
                            <th>Post Category </th>
                            <th>Post Image</th>
                            <th>Post Title En</th>
                            <th>Post Title Hin</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogpost as $item)
                        <tr>                            
                            <td>{{ $item->category->blog_category_name_en }}</td>
                            <td><img src="{{ asset($item->post_image) }}" style="width: 60px; height: 60px;" alt=""></td>
                            <td>{{ $item->post_title_en }}</td>
                            <td>{{ $item->post_title_hin }}</td>
                            <td style="width: 100px;">                            
                                <a href="{{ route('blog.post.edit',$item->id) }}" class="btn btn-info" title="Edit Brand"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('blog.post.delete',$item->id) }}" class="btn btn-danger" id="delete"><i class="fa fa-trash" title="Delete Brand"></i></a>
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




        


        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    
    </div>


@endsection