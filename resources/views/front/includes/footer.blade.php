  <footer>
  	<div class="container text-center">
	  	<div class="row">
	  		<p>&copy 2018 letsmeet.</p>
	  	</div>
	</div>
  </footer>
  

  <script src="{{url('public/front/js/jquery.min.js')}}"></script>
  <script src="{{url('public/front/js/bootstrap.min.js')}}"></script>
  <script src="{{url('public/front/js/jquery.validate.min.js')}}"></script>
  <script src="{{url('public/front/js/notify.min.js')}}"></script>
  <!-- Select 2 js -->
  <script src="{{url('public/front/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{url('public/front/js/custom.js')}}"></script>
  
  @stack('scripts')

  <script type="text/javascript">
    jQuery(function($){
      $('button.navbar-toggle').on('click',function() {
          $('.topbar').css('height','auto');
      });
    });
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