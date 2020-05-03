<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Item;
use DB;

class ItemsController extends Controller
{    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index'] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sortable items and ensure there is no more than 10 items on a page 
		$items = Item::sortable()->paginate(10);
        return view('items.index', compact('items'));
       


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //ensure that the user is not an admin 
        if(auth()->user()->role ==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
        //return view to create an item
        else return view ('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valdidation rules
       $this->validate($request,[
        'category'=>'required',
        'color'=>'required',
        'date_found'=>'required',
        'location'=>'required',
        'description'=>'required',
        'cover_image'=>'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1999',
    
       ]);
      
        
        //handle file upload 
        if ($request->hasFile('cover_image')){
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Just gets the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Gets the filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Uploads the image
            $path =$request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            }
            else {
            $fileNameToStore = 'noimage.jpg';
            }
         
      //create item
      $item = new Item;
      $item->category=$request->input('category');
      $item->color=$request->input('color');
      $item->date_found=$request->input('date_found');
      $item->location=$request->input('location');
      $item->description=$request->input('description');
      $item->user_id= auth()->user()->id;
      $item ->cover_image=$fileNameToStore;
     $item->save();
     return redirect('/items')->with('success', 'Item Created');
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

        $item= Item::find($id);
        
        return view('items.show')->with('item',$item);
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
        $item= Item::find($id);
        //check for correct user
        if(auth()->user()->role !==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
        return view('items.edit')->with('item',$item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation rules
        $this->validate($request,[
            'category'=>'required',
            'color'=>'required',
            'date_found'=>'required',
            'location'=>'required',
            'description'=>'required'
        
           ]);
            //handle file upload 
        if ($request->hasFile('cover_image')){
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Just gets the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Gets the filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Uploads the image
            $path =$request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            }

          //create item
          $item = Item::find($id);
          $item->category=$request->input('category');
          $item->color=$request->input('color');
          $item->date_found=$request->input('date_found');
          $item->location=$request->input('location');
          $item->description=$request->input('description');
          if ($request->hasFile('cover_image')){
              $item->cover_image =  $fileNameToStore;
            }
          $item->save();
         return redirect('/items')->with('success', 'Item Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('user_requests')->where('item_id', $id)->delete();
        $item=Item::find($id);
        //check for correct user
        if(auth()->user()->role !==1){
            return redirect('/items')->with('error','Unauthorized page');
        }
        if($item->cover_image !='noimage.jpg'){
            //Delete image
            Storage::delete('public/cover_images/'.$item->cover_image);
        }
        $item->delete();
        return redirect('/items')->with('success', 'Item Removed');
    }
}
