@foreach($posts as $post)
	@include('post.list')
@endforeach	
@if($posts->hasMorePages())
	<a class="pagination-link button hollow small expanded" data-content="all-content" data-url="{{$posts->nextPageUrl()}}">
		Show more
	</a>
@endif