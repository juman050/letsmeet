@extends('front.master')
@section('title')
    Conversation
@endsection
@section('mainContent')
<div class="container" id="app">
  <h3 class=" text-center">Messaging</h3>
  <div class="messaging row">
        <div class="inbox_msg col-md-12">
          <div class="inbox_people col-md-4">
            <div class="headind_srch col-md-12">
              <div class="recent_heading col-md-4">
                <h4>Recent</h4>
              </div>

              <div class="srch_bar col-md-8">
                <div class="stylish-input-group">
                  <a href="{{url('/conversations')}}">All message</a>
                </div>

              </div>
            </div>
            <div class="inbox_chat col-md-12">
              @foreach($userIds as $users)
              <div class="chat_list" v-on:click="seen = true" @click="followID( {{$users}} )">
                <div class="chat_people">

                  <div class="chat_img">
                    <?php
                      $getUser = DB::table('meetusers')->where('id','=',$users)->get();
                      $user_img = $getUser[0]->user_photo ? $getUser[0]->user_photo : 'noprofile.png';
                    ?>
                    <img src="{{url('public/front/images/users/'.$user_img)}}"/>
                  </div>
                  <div class="chat_ib">
                    <h5>{{$getUser[0]->name}}</h5>
                    <p>{{$getUser[0]->about_you}}</p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="mesgs col-md-6">
            <p class="alert alert-success" v-if="msg">@{{msg}}</p>
            <div class="type_msg" v-if="seen">
              <div class="input_msg_write">
                <input type="hidden" v-model="follow_id">
                <input type="text" class="write_msg" placeholder="Type a message" v-model="newMsgFrom" @keydown="inputHandler"/>
                <button class="msg_send_btn" type="button" @click="sendNewMsg()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
        </div>      
    </div>
</div>
@endsection

@push('styles')
<style type="text/css">
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  overflow: hidden;
  border-right:1px solid #c4c4c4;
}
.inbox_msg {
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {}
.srch_bar {
  text-align: right;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;    outline: 0;}


.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
  cursor: pointer;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #e5dff2  none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  padding: 30px 15px 0 25px;
}

 .sent_msg p {
  background: #7150b8  none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
      padding: 5px;
    outline: 0;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
@endpush


@push('scripts')
<script src="{{ asset('public/js/message.js') }}"></script> 
@endpush