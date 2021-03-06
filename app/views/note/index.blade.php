@extends('layouts/main')
@section('content')
<h1>{{ $annotation->user()['name'] }}'s Note</h1>
	<div class="content col-md-12">
		<div class="row">
			<h3>Original Passage</h3>
			<div class="col-md-12">
				<blockquote>{{ $annotation->quote() }}</blockquote>
			</div>
		</div>
		<div class="row">
			<h3>Note</h3>
			<div class="col-md-12">
				<p>{{ Markdown::render($annotation->text()) }}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<a href="{{ URL::to('user/' . $annotation->user()['id']) }}">{{ $annotation->user()['name'] }}</a>
			</div>
			<div class="col-md-3">
				<p><span id="note_{{$annotation->id()}}_likes">{{ $annotation->likes() }}</span> likes, <span id="note_{{$annotation->id()}}_dislikes">{{ $annotation->dislikes() }}</span> dislikes</p>
			</div>
		</div>
		@if(count($annotation->comments()))
			<div class="row">
				<h3>Comments</h3>
				@foreach($annotation->comments() as $comment)
					<div class="col-md-12">
						<div class="row">
							<blockquote>
								{{ $comment['text'] }}
								<div class="comment-author">
									<a href="{{ URL::to('user/' . $comment['user']['id']) }}">{{ $comment['user']['name'] }}</a>	
								</div>
							</blockquote>
						</div>
					</div>
				@endforeach
			</div>
		@endif
	</div>
	{{-- HTML::script('js/note.js') --}}
@endsection