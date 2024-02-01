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
            ?>
            <div class="card-img_size">
              <img class="card-img-top" src="{{ url('public/front/images/users/'.$user_img) }}" alt="image">
            </div>
					  
            <h4 class="card-title">{{ $user->name }}</h4>
            <form action="{{ url('/profile/upload') }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <input type="file" name="user_photo" class="form-control user_file">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-success" value="Change Profile">
              </div>
            </form>
					  
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
					    <p class="card-text"><a href="javascript:void(0)" class="btn btn-default btn-editprofile" data-toggle="modal" data-target="#editprofile">Edit Profile</a></p>
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
					<ul>
					@include('front.home.posts')
					</ul>
				</div>
				<div class="col-md-3">
				</div>
		</div>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit Profile
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form class="form-horizontal" role="form" action="{{ url('/profile/update') }}" method="post" id="edit_user">
                	{{ csrf_field() }}
                  <div class="form-group">
                    <label  class="col-sm-3 control-label"
                              for="inputEmail3">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" 
                        id="inputEmail3" placeholder="Email" value="{{ $user->email }}" readonly/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-3 control-label"
                              for="fullname">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" 
                        id="fullname" placeholder="Name" name="name" value="{{ $user->name }}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label"
                          for="inputPassword3" >New Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control"
                            id="inputPassword3" name="password" placeholder="Password"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"
                          for="about_you" >About You</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="about_you" id="about_you" placeholder="about you">{{ $user->about_you }}</textarea> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" >Gender</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="gender">
                        	<option value="male" <?php if ($user->gender == "male"): ?>
                        		selected="selected"
                        	<?php endif ?> >Male</option>
                        	<option  value="female" <?php if ($user->gender == "female"): ?>
                        		selected="selected"
                        	<?php endif ?>>Female</option>
                        </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                      <button type="submit" class="btn btn-success">Update Changes</button>
                    </div>
                  </div>
                </form>    
            </div>
           
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    jQuery(function($){

    	/*edit user*/
    	var edit_user=$("#edit_user");
        $( "#edit_user" ).validate({
          rules: {   
            name: {
              required: true              
            },
            password:  {
              minlength: 5
            },
            gender:  {
              required: true,
            }        
          },
          messages: {    
            name: {
              required:'<span style="color:#ff6262;">Name Required!</span>'
              },     
            password:{
                minlength: '<span style="color:#ff6262;">Minimum 5 Charracters!</span>'
            },
            gender:{
              required: '<span style="color:#ff6262;">Gender Required!</span>',
            }
          }
            
        });
    });
</script>
@endpush
@push('scripts')
<script type="text/javascript">
jQuery(function($){
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