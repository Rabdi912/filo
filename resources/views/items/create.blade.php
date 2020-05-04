@extends('layouts.app')
@section('content')
<center><h1>Create Item</h1></center>
<br>
<form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
    <div class="card">
        <div class="form-group-row col-md-4">
            <!-- CSRF Token -->
            @csrf
            <!-- category is a dropdown element -->
            <br>
            <label>Category</label>
            <select name="category">
                <option value="phones">Phones</option>
                <option value="pets">Pets</option>
                <option value="jewellery"> Jewellery</option>
            </select>
        </div>
        <!-- Text input for the color of the item. -->
        <div class="col-md-4">
            <label>Color</label>
            <input type="text" name="color" placeholder="Color" />
        </div>
        <!-- Text input for the date_found on the item. -->
        <div class="col-md-4">
            <label>Date Found:</label>
            <input type="date" name="date_found" placeholder="date_found" />
        </div>
        <!-- Text input for the location on the item. -->
        <div class="col-md-4">
            <label>Location</label>
            <input type="text" name="location" placeholder="Location" />
        </div>
        <div class="col-md-4">
        <!-- Text Input for the description of the item used ck-editor for style. -->
        <label>Description</label>
        </div>
        <div class="col-md-12">
        <textarea name="description" cols="30" rows="10" id="article-ckeditor"></textarea>
        </div>
        <!-- File input for the image of the item. -->
        <br>
        <div class="form-group col-md-4">
            <label>Image</label>
            <input type="file" name="cover_image[]" multiple="true" placeholder="Image File" />
        </div>
    </div>
    <!-- Buttons to submit or reset the form -->
    <br>
    <div class="col-md-6 col-md-offset-4">
        <input type="submit" class="btn btn-primary" />

        <input type="reset" class="btn btn-primary" />
    </div>
</form>
<br>
@endsection