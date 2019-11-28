@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <a href= "{{url('/Create')}}" type="button" class="btn btn-lg btn-block btn-primary">Create</a>
            <a href= "{{url('/Employee')}}" type="button" class="btn btn-lg btn-block btn-success">List</a>
            {{-- <a href= "{{url('/Update')}}" type="button" class="btn btn-lg btn-block btn-danger">Update</a>
            <a href= "{{url('/Delete')}}" type="button" class="btn btn-lg btn-block btn-warning">Delete</a> --}}
            <a href= "{{url('/USDToGoldCalc')}}" type="button" class="btn btn-lg btn-block btn-info">USD to Gold calculator</a>
        </div>
    </div>
       
@endsection
