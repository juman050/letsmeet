@extends('front.master')
@section('title')
   User Activity
@endsection
@push('styles')
<link rel="stylesheet" href="{{url('public/front/css/bootstrap-datetimepicker.min.css')}}">
@endpush
@section('mainContent')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="feedcontent">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
					<h4>create your activity</h4>
          <form action="{{ url('/create-activity') }}" method="post">
            {{ csrf_field() }}  
            <div class="form-group">
              <input type="text" class="form-control" name="activity_name" placeholder="activity name" required="">
            </div>
<!--             <div class="form-group">
              <input type="date" class="form-control" name="activity_start" placeholder="activity start" required="">
            </div> -->
            <div class="form-group">
              <div class='input-group date' id='datetimepicker1'>
               <input type='text' class="form-control" name="activity_start" placeholder="activity start" required=""/>
               <span class="input-group-addon">
               <span class="fa fa-calendar"></span>
               </span>
            </div>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="" placeholder="meeting place" id="location" required="">
              <input type="hidden" name="location_id" value="" id="location_id">
              <div id="location-list"></div>
            </div>
            
            <div class="form-group">
              <select multiple class="form-control multiple-select" name="friend_ids[]" placeholder="select your friends" id="friends" required="">
                @foreach($followees as $follow)
                  <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                @endforeach
              </select>
            </div>
            <div id="friend-list"></div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
				</div>
				<div class="col-md-4">
          <h4>Your activity</h4>
          <ul class="activity-div">
              @foreach($activity as $activities)
                <li class="activity-list" data-activity_id="{{$activities->activity_id}}">
                  <p><b>{{$activities->activity_name}}</b>
                   <small>{{ \Carbon\Carbon::parse($activities->created_at)->diffForHumans() }}</small></p>
                  <p>location : {{$activities->name}}</p>
                  <p>date : {{$activities->activity_start}}</p>
                  <?php 

                    $invites = DB::table('users_invites')
                              ->where('activity_id','=', $activities->activity_id)
                              ->get();
                    echo "<span class='text-info invites'> Total invites (".count($invites).")</span>";

                    $pending = DB::table('users_invites')
                              ->where([
                                   'activity_id'=>$activities->activity_id,
                                   'response'=>'pending'
                                  ])
                              ->get();
                    echo "<span class='text-warning pending'> not respond (".count($pending).")</span>";

                    $going = DB::table('users_invites')
                              ->where(
                                  [
                                   'activity_id'=>$activities->activity_id,
                                   'response'=>'going'
                                  ]
                                )
                              ->get();
                    echo "<span class='text-success going'> going (".count($going).")</span>";   

                    $not_going = DB::table('users_invites')
                              ->where(
                                  [
                                   'activity_id'=>$activities->activity_id,
                                   'response'=>'not_going'
                                  ]
                                )
                              ->get();
                    echo "<span class='text-danger not_going'> not going (".count($not_going).")</span>";

                  ?>
                </li>
              @endforeach
          </ul>
				</div>
        <div class="col-md-4">
          <h4>Activity request</h4>
          <?php 
            $user_id =  Session::get('user_id');
            $pending_invites = DB::table('users_invites')
                              ->where('user_id','=', $user_id)
                              ->where('response','=','pending')
                              ->get();
            $requests = count($pending_invites);
          ?>
          <p><span class="text-warning">activity request ({{$requests}})</span></p>
          <ul>
          @foreach($pending_invites as $pending)
          <?php 
            $activity = DB::table('activities')
                              ->where('activity_id','=', $pending->activity_id)
                              ->get();
          ?>
            <li ><b>{{ $activity[0]->activity_name }}</b> <br><a href="">going</a> <br><a href="">not going</a></li>
          @endforeach
        </ul>
        </div>
		</div>
	</div>
</section>



@endsection

@push('scripts')

<script type="text/javascript">
    jQuery(function($){
      $(document).on('keyup',"#location",function(){

        var location = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: '{{ url("/find-location") }}',
          type: 'POST',
          data: {_token:_token, location: location},
           success: function (response) {
            $("#location-list").empty();
            $("div#location-list").show();
            $("#location-list").html(response);
          },
          error: function (response) {
            alert('Error:', response);
          }
        });
      });
      $(document).on('click','.locations-id', function (event) {
        event.preventDefault();
        var location_id = $(this).data('id');
        var location = $(this).data('name');
        $("#location_id").val(location_id)
        $("#location").val(location)
        $("div#location-list").fadeOut();
        /* Act on the event */
      });

    $('#friends').select2();
    });
</script>
<script src="{{url('public/front/js/jquery.min2.js')}}"></script>
<script src="{{url('public/front/js/moment.min.js')}}"></script>
<script src="{{url('public/front/js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript">
  jQuery(function($){
    $('#datetimepicker1').datetimepicker();
  });
</script>

@endpush