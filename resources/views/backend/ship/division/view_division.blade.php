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
                <h3 class="box-title">Division List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Division Name</th>                            
                            <th>Action</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($divisions as $item)
                        <tr>
                            <td>{{ $item->division_name }}</td>
                            
                            <td style="width: 45%;">                            
                                <a href="{{ route('division.edit',$item->id) }}" class="btn btn-info" title="Edit Brand"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('division.delete',$item->id) }}" class="btn btn-danger" id="delete"><i class="fa fa-trash" title="Delete Brand"></i></a>
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


<!-- ------------------ Add Category Page  ------------------ -->

        <div class="col-md-4 col-sm-4">

        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"> Add Division</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                

            <form method="post" action="{{ route('division.store') }}" >
                    @csrf          
                        
                    
                        <div class="form-group">
                            <h5>Division Name </h5>
                            <div class="controls">
                                <input  type="text" name="division_name" class="form-control"  >
                                @error('division_name')
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