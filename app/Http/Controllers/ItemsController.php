<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Item;
use DB;
use File;

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
        //messages if the image does not meet the requirments 
        $messages = [    
			'cover_image.max' => 'you have reached the maximium image uplaod.upload 3 images only!!.',
			'cover_image.*.mimes' => 'Invalid file formats.check the format.jpeg,png,jpg,gif,svg!',
			'cover_image.*.max' => 'Image size must be 1mb at max',
		];
        //valdidation rules
       $validator = Validator::make($request->all(), [
        'category'=>'required',
        'color'=>'required',
        'date_found'=>'required',
        'location'=>'required',
        'description'=>'required',
        'cover_image*'=>'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1999',
        'cover_image'=>'sometimes|max:3 images'
        ], $messages);
        //check if the validation fails then show errors 
        if ($validator->fails()) {
            return redirect('create')
                        ->withErrors($validator)
                        ->withInput();
        }
        //handle file uplaod
        $cover_images_to_store=array('');
        //handle file upload 
        if($request->hasFile('cover_image')){
            foreach($request->file('cover_image') as $image){
            //Gets the filename with the extension
            $fileNameWithExt = $image->getClientOriginalName();
            //replaces spaces in file name with an underscore
            $fileNameWithExt = preg_replace('/\s+/','_', $fileNameWithExt);
             //just gets the filename
             $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
             //Just gets the extension
             $extension = $image->getClientOriginalExtension();
             //Gets the filename to store
             $fileNameToStore = $filename.'_'.time().'.'.$extension ;
             //Uploads the image
             $path =$image->storeAs('public/cover_images', $fileNameToStore);
             array_push($cover_images_to_store, $fileNameToStore );
        }
         }
            else {
            $input_image="";
            }
            $input_image=implode(" ",$cover_images_to_store);
            $input_image=ltrim($input_image);   
         
      //create item
      $item = new Item;
      $item->category=$request->input('category');
      $item->color=$request->input('color');
      $item->date_found=$request->input('date_found');
      $item->location=$request->input('location');
      $item->description=$request->input('description');
      $item->user_id= auth()->user()->id;
      $item->cover_image=$input_image;
     $item->save();
     return redirect('items')->with('success', 'Item Created');
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
        //messages if the image does not meet the requirments 
        $messages = [    
			'cover_image.max' => 'you have reached the maximium image uplaod.upload 3 images only!!.',
			'cover_image.*.mimes' => 'Invalid file formats.check the format.jpeg,png,jpg,gif,svg!',
			'cover_image.*.max' => 'Image size must be 1mb at max.',
        ];
        //valdidation rules
       $validator = Validator::make($request->all(), [
        'category'=>'required',
        'color'=>'required',
        'date_found'=>'required',
        'location'=>'required',
        'description'=>'required',
        'cover_image*'=>'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1999',
        'cover_image'=>'sometimes|max:3 images'
        ], $messages);
        //check if the validation fails then show errors 
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }   
        
          //handle file upload
        $cover_images_to_store=array('');
        //handle file upload 
        if($request->hasFile('cover_image')){
            foreach($request->file('cover_image') as $image){
            //Gets the filename with the extension
            $fileNameWithExt = $image->getClientOriginalName();
            //replaces spaces in file name with an underscore
            $fileNameWithExt = preg_replace('/\s+/','_', $fileNameWithExt);
             //just gets the filename
             $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
             //Just gets the extension
             $extension = $image->getClientOriginalExtension();
             //Gets the filename to store
             $fileNameToStore = $filename.'_'.time().'.'.$extension ;
             //Uploads the image
             $path =$image->storeAs('public/cover_images', $fileNameToStore);
             array_push($cover_images_to_store, $fileNameToStore );
            }
         }
            else {
            $input_image="";
            }
            $input_image=implode(" ",$cover_images_to_store);
            $input_image=ltrim($input_image);   


          //create item and save the object
          $item = Item::find($id);
          $item->category=$request->input('category');
          $item->color=$request->input('color');
          $item->date_found=$request->input('date_found');
          $item->location=$request->input('location');
          $item->description=$request->input('description');
          $item->cover_image=$input_image;
          $item->save();
          //redirect HTTP response with success message
         return redirect('items')->with('success', 'Item Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
