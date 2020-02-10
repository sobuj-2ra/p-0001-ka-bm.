@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Show Customer
@endsection

<!--Page Header-->
@section('page-header')
  View Customer (<a href="{{URL::to('/customer')}}">Add Customer</a>)
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                <!-- Code Here.... -->
                    <div class="row">
                      <div class="col-xs-12">

                          <h2 style="text-align:center"><b>All Customer List</b></h2>
                      </div>
                        <div class="col-md-12">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">

                                    <table width="100%" id="showcustomer" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Customer ID</th>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Contact Person Name (Head)</th>
                                            <th scope="col">Phone Number(Head)</th>
                                            <th scope="col">Contact Person Name (Factory)</th>
                                            <th scope="col">Phone Number(Factory)</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; @endphp
                                            @foreach($showcustomer as $get_customer)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_customer->company_id}}</td>
                                            <td scope="col">{{$get_customer->company_name}}</td>
                                            <td scope="col">{{$get_customer->head_contact_name}}</td>
                                            <td scope="col">{{$get_customer->head_phone_number}}</td>
                                            <td scope="col">{{$get_customer->factory_contact_person_name}}</td>
                                            <td scope="col">{{$get_customer->factory_phone_number}}</td>

                                             <td>
                                              <a onclick="return confirm('Are you sure want to update this?');" href="{{route('editcustomer',$get_customer->id)}}"><button class="btn btn-warning">Edit </button></a>
                                              <a onclick="return confirm('Are you sure want to delete this?');" href="{{route('customerdelete',$get_customer->id)}}"><button class="btn btn-danger">Delete</button></a>
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
