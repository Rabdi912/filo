@extends('layouts.app')
@section('content')
<center><h1>Found Items</h1></center>
<br>
<!--ensure to check if there is any items in the database -->
@if(count($items)>0)
<table class="table">
        <thead>
                <tr>
                        <!--heading are sortable through kyslik link -->
                        <th> @sortablelink('id')</th>
                        <th> @sortablelink('category')</th>
                        <th>@sortablelink ('date_found') </th>
                        <th> @sortablelink('color') </th>
                        <th> </th>
                </tr>
        </thead>
        <tbody>
                <!--for loop to read the data in the database -->
                @foreach($items as $item)
                <tr>
                        <td> {{$item['id']}} </td>
                        <td> {{$item['category'] }} </td>
                        <td> {{$item['date_found']}} </td>
                        <td> {{$item['color']}} </td>
                        <!--Checks to see if the users has loged in to access the button -->
                        @if(!Auth::guest())
                        <td> <a href="/items/{{$item['id']}}"><button type="button" class="btn btn-primary">View More
                                        </button></a> </td>
                        @endif
                </tr>
                @endforeach
        </tbody>
</table>
<!-- Pagination link -->
{{$items->links()}}
@else
<p> no lost Items Found</p>
@endif
@endsection