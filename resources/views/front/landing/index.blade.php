<!DOCTYPE html>
<html lang="en">
<head>
  <title>Letsmeet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{url('public/front/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('public/front/css/land.css')}}">
</head>
<body>

  <section id="login_register">
    <div class="container">
      <div class="row">
        <div class="logo">
          <!-- <img src="{{url('public/front/images')}}/letslogo.png"> -->
        </div>
        <div class="login_form">
          <h3>Sign in to your account.</h3>
          <form action="{{url('/login')}}" id="login_form" method="post">
            {{csrf_field()}}
            <div class="form-group">
              <input type="email" class="form-control" id="email" placeholder="Enter Your Email." required="" name="email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="Enter Your Password." required="" name="password">
            </div>
            <div class="form-group">
              <p><a href="#" id="show_regsiter_form">Don't' have account?</a></p>
            </div>
            <button type="submit" class="btn btn-default sign_in">Sign In</button>
          </form>
        </div>
        <div class="register_form">
          <h3>Sign up here.</h3>
          <form action="#" method="post" id="register_form">
            {{csrf_field()}}
            <div class="form-group">
              <input type="text" class="form-control" id="name" placeholder="Enter Your Name." name="name" required="">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="email" placeholder="Enter Your Email." name="email" required="">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="Enter Your Password." name="password" required="">
            </div>
            <div class="form-group">
              <select class="form-control" id="gender" name="gender" required="">
                <option value="">Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
             <div class="form-group">
              <p><a href="#" id="show_login_form">Already have account?</a></p>
            </div>
            <button type="submit" class="btn btn-default sign_up">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script src="{{url('public/front/js/jquery.min.js')}}"></script>
  <script src="{{url('public/front/js/bootstrap.min.js')}}"></script>
  <script src="{{url('public/front/js/jquery.validate.min.js')}}"></script>
  <script src="{{url('public/front/js/notify.min.js')}}"></script>
  <script type="text/javascript">
    (function($){
      "use strict";

      /**
         * ----------------------------------------------
         * User login/register form
         * ----------------------------------------------
         */

        $("#show_regsiter_form").click(function(event) {
          $('.login_form').hide();
          $('.register_form').show();
        });
        $("#show_login_form").click(function(event) {
          $('.register_form').hide();
          $('.login_form').show();
        });

    })(jQuery); 
  </script>

  <script type="text/javascript">
    function showNotifyJs(error_msg,type){

        $.notify(
          error_msg, 
      
          {
            position:"top right",
            autoHide: true,
            // if autoHide, hide after milliseconds
            autoHideDelay: 5000,
            className: type
          }
        );
      }
  </script>
     <?php if(Session::has('notification_msg')){ 
      $notification_type=Session::get('notification_type');
      ?>

    <script type="text/javascript">
      jQuery(function($){
        var notification_msg="<?php echo Session::get('notification_msg');?>";
        var notification_type="<?php echo $notification_type;?>";
        showNotifyJs(notification_msg,notification_type);
      });
    </script>

    <?php } ?>
    <script type="text/javascript">
      jQuery(function($){
        var login_form=$("#login_form");
        $( "#login_form" ).validate({
          rules: {   
            email:  {
              required: true,
              email: true
            },
            password:  {
              required: true,
              minlength: 5
            }      
          },
          messages: {        
            email:{
              required: '<span style="color:#ff6262;">Email Required!</span>',
               email: '<span style="color:#ff6262;">Please enter a valid email address.</span>',
              },
            password:{
              required: '<span style="color:#ff6262;">Password Required!</span>',
                minlength: '<span style="color:#ff6262;">Minimum 5 Charracters!</span>'
              }
          }
            
        });
        var reg_form=$("#register_form");
        $( "#register_form" ).validate({
          rules: {   
            name: {
              required: true              
            },
            email:  {
              required: true,
              email: true
            },
            password:  {
              required: true,
              minlength: 5
            },
            gender:  {
              required: true,
            }        
          },
          messages: {    
            name: {
              required:'<span style="color:#ff6262;">User Name Required!</span>'
              },     
            email:{
              required: '<span style="color:#ff6262;">Email Required!</span>',
               email: '<span style="color:#ff6262;">Please enter a valid email address.</span>',
              },
            password:{
              required: '<span style="color:#ff6262;">Password Required!</span>',
                minlength: '<span style="color:#ff6262;">Minimum 5 Charracters!</span>'
              },
            gender:{
              required: '<span style="color:#ff6262;">Gender Required!</span>',
              }
          }
            
        });
        /*register user*/
        $('.sign_up').on('click',function(event) {
          /* Act on the event */
          event.preventDefault();
          if (reg_form.valid()) {
            var data = reg_form.serializeArray();
            $.ajax({
              url: "{{ url('api/register_user') }}",
              method:'POST',
              data: data,
            })
            .done(function(response) {             
              if (response.msg=='true') {
                var notification_msg="Account created successfully.";
                var notification_type="success";
                reg_form[0].reset();
              }else{
                var notification_msg="Email is already taken.";
                var notification_type="error";
              }
              // show success message and hide others
              showNotifyJs(notification_msg,notification_type);
            })
            .fail(function() {
              console.log("error");
              var notification_msg="you've got some error.please try again!";
              var notification_type="error";
              showNotifyJs(notification_msg,notification_type);
            })            
          }
        });
        /*login user*/
        // $('.sign_in').on('click',function(event) {
        //   /* Act on the event */
        //   event.preventDefault();
        //   if (login_form.valid()) {
        //     var data = login_form.serializeArray();
        //     $.ajax({
        //       url: "{{ url('api/login') }}",
        //       method:'POST',
        //       data: data,
        //     })
        //     .done(function(response) {             
        //       if (response.msg=='true') {
        //         window.location.href = "{{ url('home') }}"; 
        //         // redirect user page
        //       }else{
        //         var notification_msg="Email or password not match.";
        //         var notification_type="error";
        //       }
        //       // show success message and hide others
        //       showNotifyJs(notification_msg,notification_type);
        //     })
        //     .fail(function() {
        //       console.log("error");
        //       var notification_msg="you've got some error.please try again!";
        //       var notification_type="error";
        //       showNotifyJs(notification_msg,notification_type);
        //     })            
        //   }
        // });
       });
    </script> 
</body>
</html>