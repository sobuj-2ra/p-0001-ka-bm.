@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Supplier
@endsection

<!--Page Header-->
@section('page-header')
    Add Machine (<a href="{{URL::to('/viewmachine')}}">View Machine</a>)
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

                                    <div class="change_passport_body" style="width: 100% !important;">
                                        {{ csrf_field()}}
                                        <p class="form_title_center">
                                        <i> View Weigh Machine </i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <table class="table table-responsive table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Machine Name</th>
                                                            <th>Host</th>
                                                            <th>Port</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($all_machine)
                                                        @foreach($all_machine as $machine)
                                                            <tr>
                                                                <td>{{$loop->iteration }}</td>
                                                                <td>{{$machine->machine_name}}</td>
                                                                <td>{{$machine->machine_host}}</td>
                                                                <td>{{$machine->machine_port}}</td>
                                                                <td><a href="{{ URL::to('weightmachine/edit/'.$machine->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> <a href="{{ URL::to('weightmachine/delete/'.$machine->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>
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