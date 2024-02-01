<div class="all-post-lists">
@foreach($posts as $post)
	<li class="post-item post-no-{{$post->id}}">
		<div class="posts">
			<div class="feed-header">
			<?php
				$user_img = ($post->user->user_photo) ? $post->user->user_photo : 'noprofile.png';
			?>
				<a href="{{ url('/user-profile/'.$post->user->id) }}" class="account-group">
					<div class="img_size">
						<img class="avatar" src="{{ url('public/front/images/users/'.$user_img) }}" alt="">
					</div>
					<span class="fullnamegroup"><strong class="fullname">{{ $post->user->name }}</strong></span>
					
				</a>
				<small class="time">{{ $post->updated_at->diffForHumans() }}</small>
				<?php 
				    $log_user_id = Session::get('user_id');
				    if($log_user_id == $post->user_id):
				 ?>
				<div class="feed-action">
						<div class="dropdown">
						    <span class="dropdown-toggle pull-right" id="drop_control" type="button" data-toggle="dropdown">
						    <span class="caret"></span></span>
						    <ul class="dropdown-menu" role="menu" aria-labelledby="drop_control">
						     <li role="presentation"><a role="menuitem" tabindex="-1" href="#">edit</a></li> 

						      <li role="presentation"><a role="menuitem" tabindex="-1" href="#" data-post_id = "{{$post->id}}" class="delete-post-btn">Delete</a></li> 
						    </ul>
						  </div>
					</div>
					<?php endif; ?>
			</div>
			<div class="feed-container">
				<?php 
				if ($post->post_type !== "link") {?>
					<p>{{ $post->body }}</p>
		        <?php
		        }
		       	else{?>
		    		{!! $post->body !!}
			    <?php
			       }
				?>
			</div>
			<div class="feed-footer">
				<?php 
                  $log_user_id = Session::get('user_id');
                  $likes = DB::table('likes')->where('post_id',$post->id)->get();
                  $like = DB::table('likes')->where(['user_id'=>$log_user_id,'post_id'=>$post->id])->first();
                  if ($like) {
                    $classname = "dislike";
                  }else{
                    $classname = "like";
                  }
                ?>
                {{ csrf_field() }}
                <?php 
                $comment_list = App\Comment::with('children')
					->where('post_id','=',$post->id)->get();
				$comments = App\Comment::with('children')
					->where(['parent_id'=>0,'post_id'=>$post->id])->orderBy('id', 'desc')->simplePaginate(5);

				
		        ?>
				<div class="feed-footer-top">
					<p><span class="total_likes">{{$likes->count()}}</span> likes <span class="total_comments">{{ $comment_list->count() }} </span> comments <span class="total_views">34 views</span></p>
				</div>
				<div class="feed-footer-bottom">
					<a href="#" class="btn btn-sm btn-info likeOrdislike {{ $classname }}" data-post_id="{{ $post->id }}"><i class="fa fa-thumbs-up"></i>  {{$classname}}</a>
					<a href="#" class="btn btn-sm btn-primary cmntButton" data-post_id="{{ $post->id }}"> <i class="fa fa-comments-o"></i> Comment</a>
				</div>
				
			</div>

			<div class="comment_div" data-post_id="{{ $post->id }}">
				<input class="form-control comment_body comment-box-{{ $post->id }}"  placeholder="Enter a comment" />
				<input type="hidden" name="parent_id" value="0" class="parent-id-{{ $post->id }}">
				
				<ul class="comment_ul">
					@include('front.home.comments')
			    </ul>
				
			</div>
			
		</div>
	</li>
@endforeach
	<li class="post-item">{{ $posts->links() }}</li>
</div>