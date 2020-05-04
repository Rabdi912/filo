<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use\App\User;
use\App\Item;
use Illuminate\Http\Request;
use\App\UserRequest;
use Auth;
use DB;
use Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\DecisionMail;
use App\Mail\AcceptMail;

class UserRequestsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
       
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */


    public function index()
    {
        //
        $items = UserRequest::all()->toArray();
		$itemsRequested = null;
        $usersRequested = null;
        if(auth()->user()->role !==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
		//For loop to search for the items in the database
		foreach($items as $item) {
			$itemsRequested[$item['id']] = Item::find($item['item_id'])->toArray();
			$usersRequested[$item['id']] = User::find($item['user_id'])->toArray();
		}
		if($usersRequested == null) {
		    //If no requests uploaded then cant access the page.
			return redirect('/home')->with('error','No requests made!!');
		}
		else {
            //show all request in the table and dont allow more than 5 per page.
            $items= UserRequest::orderBy('id','asc')->paginate(5);
			return view('requests.show')->with(compact('items', 'usersRequested', 'itemsRequested' ));
		}
       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $item_id)
    {
       //validation rule 
         $this->validate($request,[
            'reason' => 'required',
            
           ]);
		
		$user_id = Auth()->user()->id;
        $item_id = $item_id;
        //ensure an admin can not request 
        if(auth()->user()->role ==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
       
		//Check if the user requested before.
		$requestData = ['item_id' => $item_id, 'user_id' => $user_id];
		$userRequests = DB::table('user_requests')->where($requestData)->get();
		if($userRequests != null) {
			foreach ($userRequests as $requestUser) {
				if($requestUser->approved == 0) {
					return Redirect::back()
						->withErrors('You already have a pending request for this item!');
						
                }
                
                else{
                    return Redirect::back()
                    ->withErrors('you cannot request the same item more than once!');
                     }
                }
			}
		
    
        //store the data in an array in the user_request database.
		$reason = $request->reason;
        $data = array('reason'=>$reason, 'item_id'=>$item_id, 'user_id'=>$user_id);	       
		DB::table('user_requests')->insert($data);
        return redirect('/items')->with('success', 'Item Requested ');
		
	}
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $item = Item::find($id)->toArray();
        $user = User::find($item['user_id'])->toArray();
        // ensure the user is not an admin
        if(auth()->user()->role ==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
        // ensure the user cannot request an item the user posted 
        if(auth()-> user()->id ==$item['user_id']){
            
            return redirect('/items')->with('error', 'You cannot request an item you posted');
        }
		return view('requests.index', compact('item'), compact('user'));
	  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $value = $request->accept;
        $id = $request->id;
        //locate the user who requested the item.
        $itemRequest = UserRequest::find($id);
        //make sure the user is an admin 
        if(auth()->user()->role !==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
		$user = User::find($itemRequest['user_id'])->toArray();
		//if request is approved or refused then send an email.
		if($value == 'approved') {
            $itemRequest->accept = 1;
            Mail::to($user['email'])->send(new AcceptMail());
			$itemRequest->save();
        }
        else {
            $itemRequest->accept= -1;
            $value == 'declined';
            Mail::to($user['email'])->send(new DecisionMail());
			$itemRequest->save();
			
		}
		return back();
	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete the request once decsion made 
        $request = UserRequest::find($id);
        $request->delete();
        return back()->with('success', 'Request has been deleted');
  
    }
}
