@extends('layout')
@section('title') GadgetZone @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;"> 
    <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">Admin Dashboard</a></h3>

<p class="white-text" style="font-weight:bold;"> 
   

</p>

@if (session('status'))
  
<script>
    $(document).ready(function () {
    alertify.set('notifier','position','top-right');
    alertify.alert("Status","{{ session('status') }}");
    });
</script>

@endif

</div>

 

<div class="container py-5">
    <p align="left">
        <i class="fas fa-file-powerpoint"></i> News Letter Subscription Data
   </p>
     
<div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                       
                        <th>Name</th>
                        <th>Email Id</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($NewsLetter as $item)
                        <tr>

                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                         

                                 
                    </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
</div>
</div>
<hr>
@endsection