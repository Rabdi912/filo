@extends('layouts.app')
@section('content')
<h1>Edit Item</h1>
<br>
<form method="post" action="{{ action('ItemsController@update', $item['id']) }}" enctype="multipart/form-data">
     <!-- CSRF Token -->
    @csrf
     <!-- allows Admin to edit item with all previous selected posts included -->
    <div class="card">
        <div class="form-group-row col-md-4">
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
            <label>Color</label>
            <input type="text" name="color" value={{ $item['color'] }} placeholder="Color" />
        </div>
        <div class="col-md-4">
            <label>Date Found:</label>
            <input type="date" name="date_found" value={{ $item['date_found'] }} placeholder="date_found" />
        </div>
        <div class="col-md-4">
            <label>Location</label>
            <input type="text" name="location" value={{ $item['location'] }} placeholder="Location" />
        </div>
        <div class="form-group">
            {{Form::label('description','Description')}}
            {{Form::textarea('description',$item->description,['id'=>'article-ckeditor', 'class'=>'form-control','placeholder'=>'Description Text' ])}}
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="cover_image" placeholder="Image file" />
        </div>
        <br>
        <input type="hidden" name="_method" value="PUT">
        <!-- Buttons to submit or reset the form -->
        <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-primary" />
            
            <input type="reset" class="btn btn-primary" />
        </div>
        <br>
    </div>
</form>
@endsection