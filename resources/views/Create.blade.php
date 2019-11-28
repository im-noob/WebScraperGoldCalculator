@extends('layouts.app')

@section('content')
   
    <form action="Employee" method="post">
        @csrf
        @method('POST')
        
        {{-- START:showing all errors --}}
        @foreach ($errors->all() as $message)
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
        @endforeach
        {{-- END:showign all errors --}}
        <div class="form-group">
            <label for="first_name">Email address</label>
            <input type="first_name" class="form-control" name="first_name" id="first_name" placeholder="Enter First name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Email address</label>
            <input type="last_name" class="form-control" name="last_name" id="last_name" placeholder="Enter Last name" required>
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="phone">Email address</label>
            <input type="phone" class="form-control" name="phone" id="phone" placeholder="Enter phone" size="10">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form> 

@endsection
