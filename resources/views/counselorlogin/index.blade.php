@extends('counselorlogin.layouts.app')

@section('title', 'UKRIDA 3S - Selamat datang')
    
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title text-center">Menunjukan Data history dari seriap user yang melakukan tes</h3>
                            </div>
                        </div>
                    </div>                                    
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
@include('sweetalert::alert')
@endsection