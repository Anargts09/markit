@foreach($posts as $post)
	@include('post.list')
@endforeach	
@if($posts->hasMorePages())
	<br>
	<a class="pagination-link button is-fullwidth" data-content="all-content" data-url="{{$posts->nextPageUrl()}}">
		{{trans('home.showmore')}}
	</a>
@endif