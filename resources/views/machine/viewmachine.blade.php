@extends('admin.master')
<!--Page Title-->
@section('page-title')
    View Supplier
@endsection

<!--Page Header-->
@section('page-header')
    View Machine List (<a href="{{URL::to('/addmachine')}}">Add Machine</a>)
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                       <br/>
                       @if(Session::has('message'))
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2  alert {{ Session::get('alert-class', 'alert-info') }}">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                            </div>
                        </div>
                        @endif


                <!-- Code Here.... -->
                    <div class="row">


                        <div class="col-md-12">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <table width="100%" id="addproductpage" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Machine Name</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; @endphp
                                            @foreach($show_machine as $get_machine)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_machine->machine_name}}</td>
                                            <td scope="col">{{$get_machine->remarks}}</td>
                                            <td scope="col">
                                                <a onclick="return confirm('Are you sure want to update this?');" href="{{route('editmachine',$get_machine->id)}}"><button class="btn btn-warning">Edit </button></a>
                                                <a onclick="return confirm('Are you sure want to delete this?');" href="{{route('machinedelete',$get_machine->id)}}"><button class="btn btn-danger">Delete</button></a>
                                            </td>                                            
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
@endsection