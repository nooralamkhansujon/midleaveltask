@extends('welcome')

@section('content')
<div class="container my-5">
  <div class="row">
       <div class="col-md-12">
           <ul>
                @if(session()->has('flash_error_message'))
                    <li class="alert alert-danger">{{session()->get('flash_error_message')}}</li>
                @endif 
                @if(session()->has('flash_success_message'))
                    <li class="alert alert-success">{{session()->get('flash_success_message')}}</li>
                @endif 
           </ul>
       </div>
     </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Segment Name</th>
                <th scope="col">filtered segment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($segments as $segment)
                <tr>
                    <td scope="row">{{$segment->id}}</td>
                    <td scope="row">{{$segment->sagment_name}}</td>
                    <td><a href="{{route('subscriber.filteredList',$segment->id)}}">filterd Segment</a></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
