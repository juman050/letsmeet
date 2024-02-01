@extends('front.master')
@section('title')
    Find User
@endsection
@section('mainContent')
<section class="feedcontent">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
					<div class="post-block">
						<h3>Find Users</h3>
            <form action="" method="post">
              {{ csrf_field() }}
              <div class="form-group col-md-10  search-form">
                <input class="search" placeholder="Search user by username or email">
              </div>
              <input type="button" class="col-md-2 btn btn-primary find_user" value="Search">
            </form>
			   </div>
          <div class="loader"></div>
					<ul class="search-user-list">
					   @include('front.users.lists')	
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

      $('.find_user').on('click', function(event) {
        event.preventDefault();
        var search_body = $('input.search').val();
        if (search_body!=="") {
          $('.loader').show();
          var _token = $('input[name="_token"]').val();
          $.ajax({
            url: '{{ url("/search-user") }}',
            type: 'POST',
            data: {_token: _token,search_body:search_body},
            success: function (response) {
              setTimeout(function() {
                $('.loader').hide();
                $('.search-user-list').html(response); 
              }, 1000);              
              return false;          
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