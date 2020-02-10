@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Order Request
@endsection

<!--Page Header-->
@section('page-header')
    View Order Request
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
                              <div class="col-md-6 col-md-offset-3">
                                  @if(Session::has('msg'))
                                    <div class="alert {{Session::get('status')}}">
                                      <span>{{Session::get('msg')}}</span>
                                    </div>
                                  @endif
                              </div>
                                <div class="col-md-12">

                                    <div class="change_passport_body" style="width: 100% !important;">
                                        {{ csrf_field()}}
                                        <p class="form_title_center">
                                        <i>-- View Order Request --</i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <table class="table table-responsive table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Order Request</th>
                                                            <th>Type</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($orderReqData)
                                                        @foreach($orderReqData as $orderReq)
                                                            <tr>
                                                                <td>{{$loop->iteration }}</td>
                                                                <td>{{$orderReq->order_ref_no}}</td>
                                                                <td>{{$orderReq->getRefType->product_type }}</td>
                                                                <td>{{$orderReq->request_date }}</td>
                                                                <td><a onclick="return confirm('Are you sure!! you want to delete?')" class="btn btn-danger" href="{{URL::to('order_request/view')}}/{{$orderReq->id}}">Delete</a></td>
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
