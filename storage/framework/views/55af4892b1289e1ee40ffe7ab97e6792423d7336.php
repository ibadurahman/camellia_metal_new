<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo e(route('home')); ?>" class="nav-link">Home</a>
        </li>
        
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <span class="badge badge-danger navbar-badge" id="downtime-event-count">0</span>
            <p>Downtime</p>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="downtime-event-list">
        </div>
      </li> 
    </ul>
</nav>

<?php $__env->startPush('scripts'); ?>
  <script>
    $(document).ready(function(){
      updateDowntimeData();
    });

    const Http = window.axios;
    const Echo = window.Echo;

    let channel = Echo.channel('channel-downtime');
    channel.listen('DowntimeCaptured', function(data) {
        updateDowntimeData();
    });

    function updateDowntimeData(){
      $.ajax({
          url:'<?php echo e(route('downtime.updateDowntime')); ?>',
          type:'POST',
          dataType: 'json',
          data:{
            _token: '<?php echo e(csrf_token()); ?>',
          },
          success:function(response){
            $('#downtime-event-count').html(response.data.length);
            var results = '';
            var data_length = response.data.length;
            if(response.data.length > 3)
            {
              data_length = 3;
            }
            for (let index = 0; index < data_length; index++) {
              const element = response.data[index];
              var dtState = '<span class="float-right text-sm text-success">Stopped</span>';
              var dtTime = '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>' + element.start_time + ' - ' + element.end_time + '</p>';
              if (element.dt_status == 'stop') 
              {
                dtState = '<span class="float-right text-sm text-danger">Running</span>';
                dtTime = '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>' + element.start_time + ' - Now</p>';
              }
              results += '<a href="#" class="dropdown-item">' + 
                            '<div class="media">' + 
                                '<div class="media-body">' +
                                    '<h3 class="dropdown-item-title">' +
                                        element.machine_name + ' ( ' + element.workorder.wo_number + ' )' +
                                        dtState +
                                    '</h3>' + 
                                    dtTime +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                        '<div class="dropdown-divider"></div>';

            };
            results += '<a href="<?php echo e(route('production.index')); ?>" class="dropdown-item dropdown-footer">See All Downtime</a>'
            $('#downtime-event-list').html(results);
          },
          error:function(response){
            console.log(response.responseText);
          }
        });
    }
  </script>
<?php $__env->stopPush(); ?>


<!-- /.navbar -->
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\templates\partials\navbar.blade.php ENDPATH**/ ?>