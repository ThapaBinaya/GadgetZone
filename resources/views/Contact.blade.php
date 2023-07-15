@extends('layout')
@section('title') GadgetZone - FAQ'S @endsection
@section('keywords') Home,About,Contact,Car @endsection
@section('description') Write some descripton about the webpage @endsection
@section('content')
<style>
    #body
    {
        background:#f2f2f2;
    }
    @media (max-width: 768px)
    { 
          .contactwidth
        {
            width:100%;
        }
    }
     @media (min-width: 768px)
    { 
        .contactwidth
        {
            width:60%;
        }
    }
</style>
<!-- ======= Contact Section Starts Here ======= --> 
 
<section id="contact" class="contact">
    <div class="container contactwidth"  >

      <div class="section-title">
      
        <h2>Contact</h2> 
      </div>

      <div class="row">

        <div class="col-lg-5 d-flex align-items-stretch">
          <div align="left" class="info">
            <div class="address" >
              <i class="fas fa-map-marker-alt"></i>
                <h4>Location:</h4>
                <p>  Kavre, Banepa - 45210</p>
              </div>

              <div class="email">
              <i class="fas fa-envelope"></i>
                <h4>Email:</h4>
                <p>gadgetzone2023@gmail.com</p>
              </div>

              <div class="phone">
              <i class="fas fa-phone"></i>
                <h4>Call:</h4>
                <p>Binaya : +977 9876543210<br>
                   Sudip  : +977 9876543211</p>
              </div>

              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d5490.262972517143!2d85.52298527828691!3d27.630476776220437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2snp!4v1688880100524!5m2!1sen!2snp" width="100%" height="290" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>

        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
          <form action="send-email" method="post" role="form" class="php-email-form">
              @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Your Name</label>
                <input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="validate"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="name">Your Email</label>
                <input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
                <div class="validate"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="name">Subject</label>
              <input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <label for="name">Message</label>
              <textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us"></textarea>
              <div class="validate"></div>
            </div>
             
            <div class="text-center"><button type="submit">Send Message</button></div>
          </form>
        </div>

      </div>

    </div>
</section>

<!-- ======= Contact Section Ends Here ======= --> 

  
   @if (session('status'))

        <script>
            $(document).ready(function () {

        $('#centralModalSuccess').modal('show');

        });
        </script>
@endif

@if($errors->any())

        <script>
            $(document).ready(function () {

        $('#centralModaldanger').modal('show');

        });
        </script>
@endif


 <!-- Central Modal Medium Success -->
 <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-success" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead"> Success</p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
           <p>{{session('status')}} </p>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         
         <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Close</a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Success-->
 
 <!-- Central Modal Medium Danger -->
 <div class="modal fade" id="centralModaldanger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-danger" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead"> Form Not Submitted </p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
             
           <i class="fas fa-exclamation fa-4x mb-3 animated rotateIn"></i>
           <p>@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif </p>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         
         <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Close</a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Danger-->
 
@endsection