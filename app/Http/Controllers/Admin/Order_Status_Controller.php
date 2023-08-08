<?php
namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller; 
    use App\Models\Products;
    use Illuminate\Support\Facades\Cookie;
    use Session;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Coupen_Code;
    use App\Models\Order;
    use Illuminate\Support\Facades\Auth;
    use Mail;
    use App\User;
    use Twilio\Rest\Client;

class Order_Status_Controller extends Controller
{
    public function Order_Status(Request $request, $id)
     {
        $Order_Status= Order::find($id);
        return redirect()->back()->with('Order_Status',$Order_Status)
        ->with('Order_id', $Order_Status->id)
        ->with('Shipping_Status', $Order_Status->Shipping_Status)
        ->with('Delivery_Status', $Order_Status->Delivery_Status)
        ->with('p_status', $Order_Status->p_status)
        ->with('paymentmode', $Order_Status->paymentmode)
        ->with('Order_Cancel_Status', $Order_Status->Order_Cancel_Status);
    }
    
     public function Update_Shipping_Status(Request $request)
     {
         $id=$request->input('Order_id') ;
        $Orders=Order::find($id);
        $Shipping_Status = $request->input('Shipping_Status');
        $Orders->Shipping_Status=$Shipping_Status;
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();
        
        
       
        /* Email Alert Starts Here*/
         $email=$Orders->Customer_Emailid;
         $Order_Details=$Orders->Order_Details;
                $Delivery_Address=$Orders->Delivery_Address;
             $p_method=$Orders->paymentmode;
            $Amount=$Orders->Amount;
            $status=$Orders->p_status;
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;
                            
        	                $welcomemessage='Hello '.$name.'';
        	                $emailbody='<p>Your Order has been Shipped. Your estimated delivery date is 3-5 working days. If you would like to view the status of your order or make any changes to it, please visit Your Orders on <a href="https://www.gadgetzone.com">GadgetZone.com</a></p><br>
        	                <h4>Order Details: </h4><p> Order No:'.$id.$Order_Details.'</p>
        	                 <p><strong>Delivery Address:</strong>
        	               '.$Delivery_Address.'</p>
        	                <p> <strong>Total Amount:</strong>
        	                '.$Amount.'</p>
        	                 <p><strong>Payment Method:</strong>'.$p_method.'</p>
        	                  <p><strong>Payment Status:</strong>'.$status.'</p>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$id)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        (' Your GadgetZone.com order '.$id.' is Shipped');
        	                        $message->from('codetalentum@btao.in','GadgetZone');
        	                        
        	                    });
           /* Email Alert Ends Here*/

                              // Replace these variables with your actual Twilio credentials
                                    
                            $twilioSid = '';
                            $twilioToken = '';
                            $twilioPhoneNumber = '+16625032428'; // Your Twilio phone number (e.g., '+1234567890')

                            // Create a new Twilio client with your credentials
                            $client = new Client($twilioSid, $twilioToken);

                            // try {
                                // Send an SMS using the Twilio client
                                $client->messages->create(
                                    '+9779843759348', // The recipient's phone number in international format (e.g., '+97798XXXXXXXX')
                                    [
                                        'from' => $twilioPhoneNumber,
                                        'body' => 'Hello '.$name.
                                        'Your Order has been Shipped. Your estimated delivery date is 3-5 working days.
                                        Order Details:
                                        Order No:'.$id.$Order_Details.'
                                        Delivery Address:
                                        '.$Delivery_Address.'
                                        Total Amount:'.$Amount.' /-
                                        Payment Method:'.$p_method.'
                                        Payment Status:'.$status.'',
                                    ]
                                );

        return redirect()->back()->with('status','Shipping Status Updated Succesfully');

     }
     
     public function Update_Delivery_Status(Request $request)
     {
         $id=$request->input('Order_id') ;
        $Orders=Order::find($id);
        date_default_timezone_set("Asia/Kathmandu");   //Nepal time (GMT+5:45)
         
        $Delivery_Status =  date('d-m-Y h:i:s');
        $Orders->Delivery_Status=$Delivery_Status;
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();

        /* Product quantity update starts here */
        $p_id = $Orders->product_id;
        $order_quantity = $Orders->order_quantity;
        $Product = Products::find($p_id);
        $Product->quantity = $Product->quantity - $order_quantity;
        $Product->update();
        
        /* Email Alert Starts Here*/
         $email=$Orders->Customer_Emailid;
         $Order_Details=$Orders->Order_Details;
                $Delivery_Address=$Orders->Delivery_Address;
             $p_method=$Orders->paymentmode;
            $Amount=$Orders->Amount;
            $status=$Orders->p_status;
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;
                            
        	                $welcomemessage='Hello '.$name.'';
        	                $emailbody='<p>Your Order has been delivered!<br>  </p>
        	                <h4>Your Feed Back Matters a Lot! </h4>
        	                <p> Kindly Share your feed back by using the following link <br>
        	                <a href="#">Google Form Link</a></p>
        	                ';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$id)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        ('Your GadgetZone.com order '.$id.' is Delivered');
        	                        $message->from('codetalentum@btao.in','GadgetZone');
        	                        
        	                    });
           /* Email Alert Ends Here*/

                              // Replace these variables with your actual Twilio credentials
                                    
                            $twilioSid = '';
                            $twilioToken = '';
                            $twilioPhoneNumber = '+16625032428'; // Your Twilio phone number (e.g., '+1234567890')

                            // Create a new Twilio client with your credentials
                            $client = new Client($twilioSid, $twilioToken);

                            // try {
                                // Send an SMS using the Twilio client
                                $client->messages->create(
                                    '+9779843759348', // The recipient's phone number in international format (e.g., '+97798XXXXXXXX')
                                    [
                                        'from' => $twilioPhoneNumber,
                                        'body' => 'Hello '.$name.
                                        'Your Order has been delivered!
                                        Your Feed Back Matters a Lot! 
                                        Kindly Share your feed back ',
                                    ]
                                );

        return redirect()->back()->with('status','Delivery  Status Updated Succesfully');

     }
      public function Update_Payment_Status(Request $request)
     {
         $id=$request->input('Order_id') ;
        $Orders=Order::find($id);
        $p_status = $request->input('p_status');
        $Orders->p_status=$p_status;
       $Auth = Auth::user();

       $Orders->p_status_Updated_By=$Auth->email;
        $Orders->update();
        return redirect()->back()->with('status','Payment  Status Updated Succesfully');

     }
       public function Update_paymentmode_Status(Request $request)
     {
         $id=$request->input('Order_id') ;
        $Orders=Order::find($id);
        $paymentmode = $request->input('paymentmode');
        $Orders->paymentmode=$paymentmode;
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();
        return redirect()->back()->with('status','Payment  Mode  Updated Succesfully');

     }
     public function Order_Cancel(Request $request,$id)
     { 
        $Orders=Order::find($id);
        date_default_timezone_set("Asia/Kathmandu");   //Nepal time (GMT+5:45)
         
        $Order_Cancelled_On =  date('d-m-Y h:i:s');
        $Orders->Order_Cancel_Status=1;
        $Orders->Order_Cancelled_On=$Order_Cancelled_On;
      
        
        
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();

          /* Email Alert Starts Here*/
         $email=$Orders->Customer_Emailid;
         $Order_Details=$Orders->Order_Details;
                $Delivery_Address=$Orders->Delivery_Address;
             $p_method=$Orders->paymentmode;
            $Amount=$Orders->Amount;
            $status=$Orders->p_status;
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;
                            
        	                $welcomemessage='Hello '.$name.'';
        	                $emailbody='<p>Your Order Was Cancelled Successfully on '.$Order_Cancelled_On.'<br> 
        	                As per Your Request, we have cancelled your Order. If you paid any payment with us, it will be refunded within 2-3 Working Days...</p>
        	                <h4>Order Details: </h4><p> Order No:'.$id.$Order_Details.'</p>
        	                 <p><strong>Delivery Address:</strong>
        	               '.$Delivery_Address.'</p>
        	                <p> <strong>Total Amount:</strong>
        	                '.$Amount.'</p>
        	                 <p><strong>Payment Method:</strong>'.$p_method.'</p>
        	                  <p><strong>Payment Status:</strong>'.$status.'</p>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$id)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        ('Your GadgetZone.com order '.$id.' is Cancelled');
        	                        $message->from('codetalentum@btao.in','GadgetZone');
        	                        
        	                    });
           /* Email Alert Ends Here*/

                              // Replace these variables with your actual Twilio credentials
                                    
                            $twilioSid = '';
                            $twilioToken = '';
                            $twilioPhoneNumber = '+16625032428'; // Your Twilio phone number (e.g., '+1234567890')

                            // Create a new Twilio client with your credentials
                            $client = new Client($twilioSid, $twilioToken);

                            // try {
                                // Send an SMS using the Twilio client
                                $client->messages->create(
                                    '+9779843759348', // The recipient's phone number in international format (e.g., '+97798XXXXXXXX')
                                    [
                                        'from' => $twilioPhoneNumber,
                                        'body' => 'Hello '.$name.
                                        'Your Order Was Cancelled Successfully on '.$Order_Cancelled_On.'
                                        As per Your Request, we have cancelled your Order. If you paid any payment with us, it will be refunded within 2-3 Working Days...
                                        Order Details:
                                        Order No:'.$id.$Order_Details.'
                                        Delivery Address:
                                        '.$Delivery_Address.'
                                        Total Amount:'.$Amount.' /-
                                        Payment Method:</strong>'.$p_method.'
                                        Payment Status:</strong>'.$status.'',
                                    ]
                                );
        
        return redirect()->back()->with('status','Order Cancelled Succesfully');

     }
      public function Order_Re_Cancel(Request $request,$id)
     { 
        $Orders=Order::find($id);
        date_default_timezone_set("Asia/Kathmandu");   //Nepal time (GMT+5:45)
         
        $Order_Cancelled_On =  date('d-m-Y h:i:s');
        $Orders->Order_Cancel_Status=0;
        $Orders->Order_Cancelled_On=NULL;
      
        
        
      #  $Auth = Auth::user();

       # $Orders->D_Status_Updated_By=$Auth->email;
        $Orders->update();
        return redirect()->back()->with('status','Order Re Cancelled Succesfully');

     }
     
     public function deleteorder(Request $request, $id)
    {
    
            $delete = Order::find($id);
            $delete->delete();
            return redirect()->back()->with('status','Order Removed Successfully !!');
    }
      
}