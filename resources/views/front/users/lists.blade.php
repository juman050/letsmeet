@foreach($users as $user)
					<?php
						$user_img = ($user->user_photo) ? $user->user_photo : 'noprofile.png';
					?>
						<li class="user-list">
							<a href="{{ url('user-profile/'.$user->id) }}" class="account-group">
							<div class="img_size">	
								<img class="avatar" src="{{ url('public/front/images/users/'.$user_img) }}" alt="">
              </div>
										<span class="fullnamegroup"><strong class="fullname">{{ $user->name }}</strong></span>
							</a>
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
                <a href="#" class="btn btn-info user_follow_btn followUnfollow {{ $classname }}" data-userid="{{ $user->id }}">{{ $classname }}</a>
						</li>
					@endforeach