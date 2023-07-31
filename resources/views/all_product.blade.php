@extends('layout')
@section('title') GadgetZone @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<style>

    .checked {
      color: orange;
    }
    </style> 
    

@php
$Products=App\Models\Products::where('status', '=', '1')
                            //   ->where('rating', '>=', '3')
                            //   ->orderBy('created_at', 'desc')
                            //   ->limit(4)
                              ->get();
@endphp
<!-- Products Starts Here -->
<section id="Products" align="center" class="px-5 wow animated fadeInUpBig fast" style=" font-family: 'Balsamiq Sans', cursive;">
    <hr class="col-md-12"> 
    <h1 class="black-text" align="center" style="font-weight:bold; ">ALL PRODUCTS</h1> 
    <div align="center">
        <p  class="col-md-3" style=" border-bottom: 2px solid #003399;"></p>
    </div>
    <div  class="row my-4 px-4 "  style="width:100%;" >
      @foreach($Products as $item)
      <div class="col-md-3 px-4 my-5"  >
          <div style="height: 270px; overflow:hiden;">
            <a href="{{url('Shop/'.$item->url)}}" >
              <img style="width: 100%;height: 100%;object-fit: cover;" src=" {{asset('Uploads/Products/'.$item->image1)}}" alt="" class="img-fluid">
              </a>
          </div>
          <div align="center" class="py-2" style="background:white;">
            <span class="black-text my-3" style="font-weight:bold; font-family: 'Balsamiq Sans', cursive;">{{$item->name}}</span>
            <br>
            Price : Rs. {{$item->price}}<br>
              @if($item->rating==1)
                            <span class="fa fa-star checked"></span>
                              <span class="fa fa-star"></span>
                              <span class="fa fa-star "></span>
                              <span class="fa fa-star"></span>
                              <span class="fa fa-star"></span>
                          @elseif($item->rating==2)
                          <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star "></span>
                              <span class="fa fa-star"></span>
                              <span class="fa fa-star"></span>
                            @elseif($item->rating==3)
                            <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star"></span>
                              <span class="fa fa-star"></span>
                          
                            @elseif($item->rating==4)
                            <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star"></span>
                          
                            @else
                            <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                              <span class="fa fa-star checked"></span>
                            @endif
                             
                            <br>
           
               <a href="Shop/{{$item->url}}" class="btn  btn-primary    "> Shop Now</a>
            
          </div>
      </div>  
     @endforeach

    </div>

    <hr class="col-md-12"> 
</section>
<!-- Products Ends Here --> 
 
@endsection
  