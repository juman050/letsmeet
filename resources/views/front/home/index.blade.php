@extends('front.master')
@section('title')
    HOME
@endsection
@section('mainContent')
    <section class="feedcontent">
    	<div class="container">
			<div class="row">
				<div class="col-md-3 lefbar">
					<div class="card profile_card">
						<?php
							$user_img = ($user->user_photo) ? $user->user_photo : 'noprofile.png';
						?>
					  <div class="card-img_size"><img class="card-img-top" src="{{ url('public/front/images/users/'.$user_img) }}" alt="image">
					  </div>
					  <div class="card-body">
					    <h4 class="card-title">{{ $user->name }}</h4>
					    <p class="card-text">{{ $user->about_you }}</p>
					    <p class="card-text"><a href="{{ url('/profile') }}" class="btn btn-default">See Profile</a></p>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="post-block">
						<form action="" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<textarea class="form-control post-text" id="post_body" rows="1" placeholder="whats on your mind?" name="body"></textarea>
							</div>

							<input type="button" value="post" class="btn btn-info post-btn">
						</form>

             <div class="loader"></div>
					</div>
					<ul id="all-posts">
					  @include('front.home.posts')
					</ul>
				</div>
				<div class="col-md-3">
				</div>
			</div>
	    </div>
    </section>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
  $('.loader').hide();
	/**
     * ----------------------------------------------
     * Name of section
     * ----------------------------------------------
     */
    $(document).on('click','.likeOrdislike',function(e){
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
  $(document).on('click','.post-btn', function (event) {
    event.preventDefault();
    var body = $('#post_body').val();
    if (body!=="") {
      $('.loader').show();
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url: '{{ url("/add-post") }}',
        type: 'POST',
        data: {_token: _token,body:body},
        success: function (response) {
          $('#post_body').val('');
          setTimeout(function() {
            $('.loader').hide();
            $('.all-post-lists').html(response); 
          }, 1000);
          
          return false;          
        },
        error: function (response) {
          alert('Error:', response);
        }
      });
    }
    
    
  });
  $(document).on('click','.delete-post-btn', function (event) {
    event.preventDefault();
    var post_id = $(this).attr('data-post_id');
    $.ajax({
        url: '{{ url("/delete-post") }}'+"/"+post_id,
        type: 'GET',
        success: function (response) {
          $(".post-no-"+post_id).fadeOut();   
        },
        error: function (response) {
          alert('Error:', response);
        }
      });
  });

  $(document).on('click','.cmntButton',function(event){
		event.preventDefault();
    var post_id = $(this).attr('data-post_id');
    $('.parent-id-'+post_id).val(0);
    $(this).parent().parent().next('.comment_div').toggle('swing');    
    $('.comment-box-'+post_id).focus();
	});
  $(document).on('click','.replyButton', function (event) {
    event.preventDefault();
    var post_id = $(this).attr('data-post_id');
    var comment_id = $(this).attr('data-comment_id');
    $('.parent-id-'+post_id).val(comment_id);    
    $('.comment-box-'+post_id).focus();
  });
  $(document).on('keydown','.comment_body',function(event){
    var text_area_val = $(this);
    var comment_text = text_area_val.val();
    var post_id = $(this).parent().attr('data-post_id');
    var parent_id = $('.parent-id-'+post_id).val(); 
    var _token = $('input[name="_token"]').val();
    if(event.which == 13 || event.keyCode == 13) {
        $.ajax({
          url: '{{ url("/add-comment") }}',
          type: 'POST',
          data: {_token: _token, post_id: post_id,parent_id:parent_id,comment_text:comment_text},
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
    }
  });


});
  
</script>
@endpush