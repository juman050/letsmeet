@extends('front.master')
@section('title')
    profile
@endsection
@section('mainContent')
<section class="feedcontent">
	<div class="container">
		<div class="row">
			<div class="col-md-3 lefbar">
					<div class="card profile_card">
            <?php
              $user_img = ($user->user_photo) ? $user->user_photo : 'noprofile.png';
            ?> <div class="card-img_size">
					  <img class="card-img-top" src="{{ url('public/front/images/users/'.$user_img) }}" alt="image">
					</div>
            <h4 class="card-title">{{ $user->name }}</h4>
					  
					  <ul class="nav navbar-nav col-sm-12">
				      	<li>
				      		<a href="#">
					      		<span class="profile_nav-lebel">Posts</span>
					      		<span class="profile_nav-value">
                      {{ count($posts) }}       
                    </span>
				      	   </a>
				      	</li>
				      	<li>
                  <a href="#">
                    <span class="profile_nav-lebel">Follwing</span>
                    <span class="profile_nav-value">
                      <?php
                        $followees =  count($user->followees()->pluck('follow_id')->toArray()); 
                        echo $followees;
                        ?>
                    </span>
                   </a>
                </li>
                <li>
                  <a href="#">
                    <span class="profile_nav-lebel">Followers</span>
                    <span class="profile_nav-value">
                      <?php
                        $followers =  count($user->followers()->pluck('user_id')->toArray()); 
                        echo $followers;
                        ?>       
                    </span>
                   </a>
                </li>
				      </ul>
					  <div class="card-body" >
					    <p class="card-text">{{ $user->email }}</p>
              <p class="card-text" >{{ $user->about_you }}</p>
					    <p class="card-text" id="follow_btn">
                <?php 
                  $log_user_id = Session::get('user_id');
                  $following = DB::table('follows')->where(['user_id'=>$log_user_id,'follow_id'=>$user->id])->first();
                  if ($following) {
                    $classname = "unfollow";
                  }else{
                    $classname = "follow";
                  }
                ?>
                {{ csrf_field() }}
                <a href="#" class="btn btn-info followUnfollow {{ $classname }}" data-userid="{{ $user->id }}">{{ $classname }}</a>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sendmsg">Send message</a>
              </p>

					  </div>
					</div>
				</div>
			<div class="col-md-6">
					<!-- <div class="post-block">
            <form action="{{ url('/add-post') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <textarea class="form-control post-text" rows="1" placeholder="whats on your mind?" name="body"></textarea>
              </div>
              <input type="submit" value="post" class="btn btn-info post-btn">
            </form>
          </div> -->
					<ul>
					 @include('front.home.posts')
					</ul>
				</div>
				<div class="col-md-3">
				</div>
		</div>
	</div>
</section>


<!--Msg Modal -->
<div id="sendmsg" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Message</h4>
      </div>
      <div class="modal-body">
        <form id="msg-form">
          <input type="hidden" class="following_id" value="{{ $user->id }}">
          <div class="form-group">
            <textarea class="form-control msgbox"></textarea>
          </div>
          <input type="button" class="sendmsg btn-sm btn-primary" value="Send">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    jQuery(function($){

      $(".followUnfollow").on('click', function() {
           var user_id = $(this).attr('data-userid');
           var _token = $('input[name="_token"]').val();

            if($(this).hasClass('follow')) { // FOLLOW
                $(this).html('unfollow');
                $(this).removeClass('follow').addClass('unfollow');
                $.ajax({
                  url: '{{ url("/follow") }}',
                  type: 'POST',
                  data: {_token: _token, user_id: user_id},
                  success: function (response) {
                    console.log(response.success);
                    
                  },
                  error: function (response) {
                    alert('Error:', response);
                  }
                });
                
                
            } else { // UNFOLLOW
                $(this).html('follow');
                $(this).removeClass('unfollow').addClass('follow');
                $.ajax({
                  url: '{{ url("/unfollow") }}',
                  type: 'POST',
                  data: {_token: _token, user_id: user_id},
                  success: function (response) {
                    console.log(response.success);
                    
                  },
                  error: function (response) {
                    alert('Error:', response);
                  }
                });
               
            }
       });

      $(".likeOrdislike").on('click', function(e) {
      e.preventDefault();
           var post_id = $(this).attr('data-post_id');
           var _token = $('input[name="_token"]').val();

            if($(this).hasClass('like')) { // like
                $(this).html('<i class="fa fa-thumbs-down"></i> dislike');
                $(this).removeClass('like').addClass('dislike');
                var likes_cls = $(this).parent().parent().find('.total_likes');
                var likes = $(this).parent().parent().find('.total_likes').text();
                $(likes_cls).text(parseInt(likes)+1);
                $.ajax({
                  url: '{{ url("/like") }}',
                  type: 'POST',
                  data: {_token: _token, post_id: post_id},
                  success: function (response) {
                    console.log(response.success);
                    
                  },
                  error: function (response) {
                    alert('Error:', response);
                  }
                });
                
                
            } else { // dislike
                $(this).html('<i class="fa fa-thumbs-up"></i> like');
                $(this).removeClass('dislike').addClass('like');
                var likes_cls = $(this).parent().parent().find('.total_likes');
                var likes = $(this).parent().parent().find('.total_likes').text();
                $(likes_cls).text(parseInt(likes)-1);
                $.ajax({
                  url: '{{ url("/dislike") }}',
                  type: 'POST',
                  data: {_token: _token, post_id: post_id},
                  success: function (response) {
                    console.log(response.success);
                    
                  },
                  error: function (response) {
                    alert('Error:', response);
                  }
                });
               
            }
       });
      $('.cmntButton').on('click', function (event) {
    event.preventDefault();
    $(this).parent().parent().next('.comment_div').toggle('swing');
  });
  $('.replyButton').on('click', function (event) {
    event.preventDefault();
    $(this).parent().parent().parent().parent().parent().next('.reply_div').toggle('swing');
  });

  $(".comment_body").on( "keydown", function(event) {
    var text_area_val = $(this);
    var comment_text = text_area_val.val();
    var post_id = $(this).parent().attr('data-post_id');
    var _token = $('input[name="_token"]').val();
    if(event.which == 13 || event.keyCode == 13) {
        $.ajax({
          url: '{{ url("/add-comment") }}',
          type: 'POST',
          data: {_token: _token, post_id: post_id,comment_text:comment_text},
          success: function (response) {
            text_area_val.val('');
            var total_comments = text_area_val.parent().parent().find('.total_comments').text();
            text_area_val.parent().parent().find('.total_comments').text(parseInt(total_comments)+1);
            $('.comment-data-list-'+post_id).html(response);            
          },
          error: function (response) {
            alert('Error:', response);
          }
        });
        return false;
    }
  });

  $(".reply_body").on( "keydown", function(event) {
    var text_area_val = $(this);
    var comment_text = text_area_val.val();
    var post_id = $(this).parent().attr('data-post_id');
    var parent_id = $(this).parent().attr('data-parent_id');
    var _token = $('input[name="_token"]').val();
    if(event.which == 13 || event.keyCode == 13) {
        $.ajax({
          url: '{{ url("/add-reply") }}',
          type: 'POST',
          data: {_token: _token, post_id: post_id,comment_text:comment_text,parent_id:parent_id},
          success: function (response) {
            text_area_val.val('');
            // var total_comments = text_area_val.parent().parent().find('.total_comments').text();
            // text_area_val.parent().parent().find('.total_comments').text(parseInt(total_comments)+1);
            $('.comment-data-list-'+post_id).html(response);            
          },
          error: function (response) {
            alert('Error:', response);
          }
        });
         return false;
    }
  });
  $(".sendmsg").on('click', function(e) {
      e.preventDefault();
      var _token = $('input[name="_token"]').val();
      var msg = $(".msgbox").val();
      var follow_id = $(".following_id").val();
      $.ajax({
        url: '{{ url("/sendNewMessage") }}',
        type: 'POST',
        data: {_token: _token, follow_id: follow_id, msg:msg},
        success: function (response) {
          $("div#sendmsg").modal('hide');
          
        },
        error: function (response) {
          alert('Error:', response);
        }
      });

  });
    });
</script>
@endpush