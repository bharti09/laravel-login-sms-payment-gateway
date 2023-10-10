<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\UsersPhoneNumber;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function customerIndex(){
        $customers = Customer::all();
        // $customers = json_encode($customers);
        return view('customer',compact('customers'));

    }

    public function input(){
        return view('input-component');
    }

    public function store(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'address' => 'required'
            ]
        );
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->token = $request->_token;
        $customer->save();
        return redirect('/customers/index');
    }

    public function customerEdit($id){
        $customer = Customer::find($id);
        return view('customer-edit',compact('customer'));
    }

    public function customerUpdate(Request $request, $id){
        $request->validate(
            [
                'name' => 'required',
                'address' => 'required'
            ]
        );
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->token = $request->_token;
        $customer->save();
        return redirect('/customers/index');
    }

    public function customerDestroy($id){
        $customer = Customer::find($id);
        $customer->delete();
        return redirect('/customers/index');
    }
    
    public function show()
    {
        $users = UsersPhoneNumber::all(); //query db with model
        return view('welcome2', compact("users")); //return view with data
    }
    
    public function storePhoneNumber(Request $request)
    {
        //run validation on data sent in
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:users_phone_number|numeric'
        ]);
        $user_phone_number_model = new UsersPhoneNumber($request->all());
        $user_phone_number_model->save();
        $this->sendMessage('User registration successful!!', $request->phone_number);
        return back()->with(['success'=>"{$request->phone_number} registered"]);
    }
    
    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
        ['from' => $twilio_number, 'body' => $message] );
    }

    public function sendCustomMessage(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required|array',
            'body' => 'required',
        ]);
        $recipients = $validatedData["users"];
        // iterate over the array of recipients and send a twilio request for each
        foreach ($recipients as $recipient) {
            $this->sendMessage($validatedData["body"], $recipient);
        }
        
        return back()->with(['success' => "Messages on their way!"]);
    }
}

