@extends('welcome')

@section('content')
<div class="container my-5">
     <h3>Subscriber Filtered List</h3>
    <div class="row">
        <div class="col-md-4">
            <h5 for="">Sagment Name</h5> 
        
        </div>
        <div class="col-md-4">
           <h5>{{$sagment_name}}</h5>
        </div>
    </div>


    <div class="row">
        @if($subscribers->count() > 0 )
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Birth Day</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $subscriber)
                <tr>
                <td scope="row">{{$subscriber->id}}</td>
                <td scope="row">{{$subscriber->first_name}}</td>
                <td scope="row">{{$subscriber->last_name}}</td>
                <td scope="row">{{$subscriber->email}}</td>
                <td scope="row">{{$subscriber->birth_day}}</td>
                <td scope="row">{{$subscriber->created_at}}</td>
                <td scope="row">{{$subscriber->updated_at}}</td>

                </tr>
                @endforeach

            </tbody>
        </table>
        @else 
          <h1>No Data Found</h1>
        @endif 
    </div>
</div>

@endsection
