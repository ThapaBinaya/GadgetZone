<?php
namespace App\Http\Controllers\Product_Ordering_Controller;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller; 
    use App\Models\Products;
    use App\User;
    use Illuminate\Support\Facades\Cookie;
    use Session;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Coupen_Code;
    use App\Models\Order;
    use App\Models\Transaction;
    use Illuminate\Support\Facades\Auth;
    use Twilio\Rest\Client;
    use Mail;

    


    class payment    extends Controller
    {
        public function   proceed_to_Payment(Request $request,$id)
        {
            $Order=Order::where('id','=',$id)->first();
         
            $amount=$Order->Amount;
            $email=$Order->Customer_Emailid ; 
            $id=$Order->id;

            // For testing, let's assume the amount is 100
                // $amount = 100;
                $returnUrl1 = 'http://127.0.0.1:8000/esewa/response?q=su';
                $returnUrl2 = 'http://127.0.0.1:8000/esewa/response?q=fu';

                // Replace with your actual eSewa merchant credentials
                $merchantId = 'EPAYTEST';
                $secretKey = '123456';

                $data = [
                    'amt' => $amount,
                    'txAmt' => 0,
                    'psc' => 0,
                    'pdc' => 0,
                    'tAmt' => $amount,
                    'pid' => $id,
                    'su' => $returnUrl1,
                    'fu' => $returnUrl2,
                ];

                // Generate a unique verification code
                $verificationCode = md5($merchantId . $data['tAmt'] . $data['pid'] . $secretKey);
                $data['scd'] = $merchantId;
                $data['sdc'] = $verificationCode;

                // Prepare the eSewa payment URL
                $paymentUrl = 'https://uat.esewa.com.np/epay/main';
                $redirectUrl = $paymentUrl . '?' . http_build_query($data);

                return redirect()->to($redirectUrl);


        }
        public function esewaResponse(Request $request)
        {

                $status = $request->q; 
                $amt = $request -> amt;
                $oid = $request -> oid;
                $refId = $request -> refId;
                $O_id=$oid;
                $Order=Order::find($O_id)->first();
                $Order_Details=$Order->Order_Details;
                $Delivery_Address=$Order->Delivery_Address;
                $p_method=$Order->paymentmode;
                $Amount=$Order->Amount;
                if($status=="su")
                {
                       
                   
                    $Order->p_status="success";
                    $Order->p_status_Updated_By="Automatic";
                    $Order->update();
                    $email=$Order->Customer_Emailid;      
                    $Transaction = new Transaction();
                    $Transaction->TXNID=$refId;
                    $Transaction->Order_No=$O_id;
                    $Transaction->Order_By = $Order->Order_By;
                    $Transaction->email=$email;
                    $Transaction->amount=$amt;
                    $Transaction->status="success";
                    $Transaction->save();                    
                           
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;
                            //You Paid amount of  '.$amount.' RS  for the following Order
        	                $welcomemessage='Hello '.$name.'';
        	                $emailbody='<p>Your Payment Rs.'.$amt.'/-  towards Order ID:'.$oid. ' is Successfully Paid .
                            Your Order is Confirmed. Estimated Delivery 3-5 Working days.</p>
    	                    <br>
        	                <h4>Order Details: </h4><p> Order No:'.$oid.', '.$Order_Details.'/-</p>
        	                 <p><strong>Delivery Address:</strong>
        	               '.$Delivery_Address.'</p>
        	                <p> <strong>Total Amount: </strong>Rs.
        	                '.$amt.'/-</p>
        	                 <p><strong>Payment Method:</strong>'.$p_method.'</p>
        	                  <p><strong>Payment Status:</strong> success. </p>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$oid)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        ('Your GadgetZone.com Order Payment ID:'.$oid.' is Successfully Paid.');
        	                        $message->from('codetalentum@btao.in','GadgetZone');
        	                        
        	                    });

                                
                                // Replace these variables with your actual Twilio credentials
                                    $twilioSid = '';
                                    $twilioToken = '';
                                    $twilioPhoneNumber = '+14322863224'; // Your Twilio phone number (e.g., '+1234567890')

                                    // Create a new Twilio client with your credentials
                                    $client = new Client($twilioSid, $twilioToken);

                                    // try {
                                        // Send an SMS using the Twilio client
                                        $client->messages->create(
                                            '+9779843759348', // The recipient's phone number in international format (e.g., '+97798XXXXXXXX')
                                            [
                                                'from' => $twilioPhoneNumber,
                                                'body' => 'Hello, this is a test message from Twilio!',
                                            ]
                                        );

                                    //     // If the SMS is sent successfully, return a success message
                                    //     return "SMS sent successfully!";
                                    // } catch (Exception $e) {
                                    //     // If an error occurs, return the error message
                                    //     return "Error: " . $e->getMessage();
                                    // }

                        
                    Session::forget('cart');
                    Session::forget('discount');
                    Session::forget('promocode');
                    Session::forget('response');
                    Session::forget('O_id');
                    session()->flash('success', 'Session data  is Cleared');
                    
                    
                    return redirect("/Orders")->with('status','You Paid Succesfully');  


                }
                else
                {
                    $Order=Order::find($O_id)->first();
                    $email=$Order->Customer_Emailid; 
                    $Transaction = new Transaction();
                    $Transaction->TXNID=$refId;
                    $Transaction->Order_No=$O_id;
                    $Transaction->Order_By = $Order->Order_By;
                    $Transaction->email=$email;
                    $Transaction->amount=$amt;
                    $Transaction->status=$status;
                      /* 
                      date_default_timezone_set('Asia/Kathmandu');
                    $date=date("l jS \of F Y h:i:s A");
                    $Transaction->created_at=$date;
                    */
                    $Transaction->save();
                            $User=User::where('email','=',$email)->first();
                            $loginid=$email;
                            $name=$User->name;
                      $welcomemessage='Hello '.$name.'';
        	                $emailbody=' <p>Your Payment '.$amt.' towards Order '.$oid. 'is failed. <br>
        	                You Can Try Again by using the following link: <br>
        	                <a href="https://www.gadgetzone.com/proceed_to_Payment/'.$oid.'">https://www.gadgetzone.com/proceed_to_Payment/'.$oid.'</a></p>
        	                <h4>Order Details: </h4><p> Order No:'.$oid.$Order_Details.'</p>
        	                 <p><strong>Delivery Address:</strong>
        	               '.$Delivery_Address.'</p>
        	                <p> <strong>Total Amount:</strong>
        	                '.$amt.'</p>
        	                 <p><strong>Payment Method:</strong>'.$p_method.'</p>
        	                  <p><strong>Payment Status:</strong>'.$status.'</p>';
        	                $emailcontent=array(
        	                    'WelcomeMessage'=>$welcomemessage,
        	                    'emailBody'=>$emailbody
        	                   
        	                    );
        	                    Mail::send(array('html' => 'emails.order_email'), $emailcontent, function($message) use
        	                    ($loginid, $name,$oid)
        	                    {
        	                        $message->to($loginid, $name)->subject
        	                        ('Your GadgetZone Order '.$oid.' Payment is Failed');
        	                        $message->from('codetalentum@btao.in','GadgetZone');
        	                        
        	                    });
                    Session::forget('cart');
                    Session::forget('discount');
                    Session::forget('promocode');
                    session()->flash('success', 'Session data  is Cleared');

                    session(['payment_failure' =>"Your Payment Failed" ]);
                    session(['O_id' =>$oid ]);
                    session()->reflash();   
                    
                    return view("Product-Order-Screens.response")->with('payment_failure','You Payment was Unsuccesfull');  

                }       
        }
           
       
    }