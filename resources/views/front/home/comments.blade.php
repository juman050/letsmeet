<div class="comment-data-list-{{ $post->id }}">
	@foreach($comments as $comment) 
				<?php 
					$cmnt_user_img = ($comment->user->user_photo) ? $comment->user->user_photo : 'noprofile.png';
				?>
				   <li class="comment_list comment-{{$comment->post_id}}">
				   	  <div class="col-md-12">
				   	  	<div class="row">
							<div class="col-sm-2">
								<div class="img_size">
									<img class="avatar" src="{{ url('public/front/images/users/'.$cmnt_user_img) }}">
								</div><!-- /thumbnail -->
							</div><!-- /col-sm-2 -->

							<div class="col-sm-10">
								<div class="panel panel-default">
									<div class="panel-heading">
									<a href="{{ url('/user-profile/'.$comment->user->id) }}"><strong>{{$comment->user->name}}</strong> </a><span class="text-muted">commented {{ $comment->updated_at->diffForHumans() }}</span>
									</div>
									<div class="panel-body">
									{{ $comment->comment_text }}
									<input type="button" class="btn btn-sm btn-success replyButton" value="reply" data-comment_id="{{ $comment->id }}" data-post_id="{{ $post->id }}">
									</div><!-- /panel-body -->
								</div><!-- /panel panel-default -->
							</div><!-- /col-sm-10 -->
						</div><!-- /row -->
				   	  </div>
				   	
					
				  <div class="reply_div" >
				  	
				   @if ( $comment->children )
				   <ul class="reply_ul">
				   	
				   	<?php 
				   		$childrens = $comment->children;
				   	?>
				       @foreach($childrens as $rep1)
				       <?php 
							$reply_user_img = ($rep1->user->user_photo) ? $rep1->user->user_photo : 'noprofile.png';
						?>
				          <li> 

				          	<div class="col-md-12">
						   	  	<div class="row">
									<div class="col-sm-2">
										<div class="img_size">
											<img class="avatar" src="{{ url('public/front/images/users/'.$reply_user_img) }}" alt="">
										</div><!-- /thumbnail -->
									</div><!-- /col-sm-2 -->

									<div class="col-sm-10">
										<div class="panel panel-default">
											<div class="panel-heading">
											<a href="{{ url('/user-profile/'.$rep1->user->id) }}"><strong>{{ $rep1->user->name }}</strong> </a><span class="text-muted">replied {{ $rep1->updated_at->diffForHumans() }}</span>
											</div>
											<div class="panel-body">
											{{ $rep1->comment_text }}
											</div><!-- /panel-body -->
										</div><!-- /panel panel-default -->
									</div><!-- /col-sm-10 -->
								</div><!-- /row -->
						   	  </div>
						</li>
				       @endforeach
				    </ul>
				   @endif
				</div>
				   </li>
				@endforeach
</div>