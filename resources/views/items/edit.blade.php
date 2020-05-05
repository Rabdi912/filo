@extends('layouts.app')
@section('content')
<center><h1>Edit Item</h1></center>
<br>
<form  method="POST"
action="{{ action('ItemsController@update',$item['id']) }} "
enctype="multipart/form-data">
     <!-- CSRF Token -->
    @csrf
      <!-- Shows original category selected and options in dropdown version -->
    <div class="card">
        <div class="form-group-row col-md-4">
            <br>
            <label>Category</label>
            <select name="category" >
                <option value="{{$item['category']}}">Previously: {{$item['category']}}</option>
                <option value="phone">Phones</option>
                <option value="Pets">Pets</option>
                <option value="Jewellery"> Jewellery</option>
            </select>
            </select>
        </div>
        <div class="col-md-4">
             <!-- Shows original color-->
            <label>Color</label>
            <input type="text" name="color" value={{ $item['color'] }} placeholder="Color" />
        </div>
        <div class="col-md-4">
            <!-- Shows original date_found-->
            <label>Date Found:</label>
            <input type="date" name="date_found" value={{ $item['date_found'] }} placeholder="date_found" />
        </div>
        <div class="col-md-4">
            <!-- Shows original Location-->
            <label>Location</label>
            <input type="text" name="location" value={{ $item['location'] }} placeholder="Location" />
        </div>
        <div class="form-group col-md-12">
            <!-- Shows original description-->
            {{Form::label('description','Description')}}
            {{Form::textarea('description',$item->description,['id'=>'article-ckeditor', 'class'=>'form-control','placeholder'=>'Description Text' ])}}
        </div>
        <!-- option to change image-->
        <div class="form-group col-md-4">
            <label>Image</label>
            <input type="file" name="cover_image[]"  multiple="true" placeholder="Image file" />
        </div>
        <br>
        <!-- Buttons to submit or reset the form -->
        <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-primary" />
            
            <input type="reset" class="btn btn-primary" />
        </div>
        <br>
    </div>
</form>
@endsection