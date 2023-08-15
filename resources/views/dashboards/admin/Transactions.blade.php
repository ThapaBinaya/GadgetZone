@extends('layouts.admin')
@section('title') GadgetZone @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<div align="center" style="background:#1CD5E8;padding:20px;">
  <h3  class="black-text" style="font-weight:bold;"><a href="{{url('admin-dash')}}">Admin Dashboard</a></h3>
<p class="white-text" style="font-weight:bold;">Transaction Details </p>

@if (session('status'))
  
<script>
    $(document).ready(function () {
    alertify.set('notifier','position','top-right');
    alertify.alert("Status","{{ session('status') }}");
    });
</script>

@endif  

</div>


 <!-- Payments Section Starts Here-->
 <section id="mytransactionsindesktopmode">

    @include('components.admin.mytransactionsindesktopmode')
</section>
 <section id="mytransactionsinmobilemode">

    @include('components.admin.mytransactionsinmobilemode')
  </section>

<!-- Payments Section Ends Here-->
  
@endsection