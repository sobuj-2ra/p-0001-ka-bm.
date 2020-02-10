@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Batcher
@endsection

<!--Page Header-->
@section('page-header')
    View Batcher History
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
                                        <i> View Batcher History </i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <table class="table table-responsive table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Order ref</th>
                                                            <th>Unique id</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($all_batch_his)
                                                        @foreach($all_batch_his as $batch_his)
                                                            <tr>
                                                                <td>{{$loop->iteration }}</td>
                                                                <td>{{$batch_his->order_ref}}</td>
                                                                <td>{{$batch_his->unique_id }}</td>
                                                                <td><a href="{{ URL::to('batcher_reprint_barcode/'.$batch_his->order_ref.'/'.$batch_his->unique_id) }}" class="btn btn-sm btn-warning">Reprint</a></td>
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
