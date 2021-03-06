@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="card">
			<div class="card-header">
				<!-- view the admin will see when request has been made -->
				<center><h1>Requested Items</h1></center>
			</div>
			<div class="content">
				<!-- Show details of requested item. -->
					<table class="table table-responsive">
						<tr>
							<th>Category</th>
							<th>Item Details</th>
							<th>Reason</th>
							<th>Requestee Name</th>
							<th>Requestee Email</th>
							<th>Status </th>
							<th>Actions</th>
						</tr>
						<!-- For loop of all requested item. -->
						@foreach($items as $item)
						<tr>
							<td>{{$itemsRequested[$item['id']]['category']}}</td>
							<td> <a href="{{action('ItemsController@show', $item['item_id'])}}" class="btn btn-primary">View</a> </td>
							<td >{{$item['reason']}}</td>
							<td>{{$usersRequested[$item['id']]['name']}}</td>
							<td>{{$usersRequested[$item['id']]['email']}}</td>
							<!-- status of request -->
							@if($item['accept'] == 1)
							<td>Approved</td>
							@elseif ($item['accept'] == -1)
							<td>Declined</td>
							@else
							<td>Pending</td>
							@endif
							<!--form to allow admin to make a decision -->
							@if($item['accept'] == 0)
							<td>

								<form method="post" action=" {{ route('requestsitems', ['id'=>$item['id']] ) }}">
									<button class="btn btn-success"type="submit" value=approved name=accept >Accept</button>
									<button class="btn btn-danger" type="submit" value=declined >Decline</button>
									@csrf
								</form>
							</td>
							<!-- if request has been made allow admin to remove the request from the table  -->
							@else
							
									
									<td>
										<!-- Option to delete request -->
										<a type="button" class="btn btn-outline-danger"
											href="{{ route('destroyrequest',  $item['id']) }}">Delete</a>
									</td>
	
						
							@endif
							<td></td>
						</tr>
						@endforeach
					</table>
					{{$items->links()}}
				@csrf
			</div>
		</div>

	</div>
</div>
@endsection