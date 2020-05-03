@extends('layouts.app')
@section('content')
<!--ensures that the admin cannot request an item -->
@if(!Auth::user()->role==1)
<a href="/requests/{{$item->id}}" class="btn btn-primary float-right">Request</a>
@endif
<!--the view the user will see when viewing item details -->
<br>
<br>
<center><h1>Found Item</h1></center>
<br>
<img style="width:100%" src="/storage/cover_images/{{$item['cover_image']}}">
<div class="card">
    <center>
        <div class="card-header">Display Description </div>
    </center>
    <div class="card-body">
        <table class="table table-hover">
            <tr>
                <th> id</th>
                <td> {{$item->id}} </td>
            </tr>
            <tr>
                <th> Category</th>
                <td> {{$item->category }} </td>
            </tr>
            <tr>
                <th> Date Found </th>
                <td> {{$item->date_found}} </td>
            </tr>
            <tr>
                <th> Color </th>
                <td> {{$item->color}} </td>
            </tr>
            <tr>
                <th> Location </th>
                <td> {{$item->location}} </td>
            </tr>
            <tr>
                   <!-- using !! helps parse the html used by ck-editor -->
                <th> Description </th>
                <td> {!!$item->description!!} </td>
            </tr>
    </div>
</div>

</table>
<small>Written on {{$item->created_at}} by {{$item->user->name}}</small>
<!--Checks if user is admin; only allows admin to delete and edit items -->
@if(!Auth::guest())
@if(Auth::user()->role==1)
<hr>
<a href="/items/{{$item->id}}/edit" class="btn btn-primary">Edit</a>
{!!Form::open(['action'=>['ItemsController@destroy',$item->id], 'method'=>'POST', 'class' =>'float-right'])!!}
{{Form::hidden('_method','DELETE')}}
{{Form::submit('Delete',['class'=> 'btn btn-danger'])}}
{!!Form::close()!!}
@else
@endif
@endif
@endsection