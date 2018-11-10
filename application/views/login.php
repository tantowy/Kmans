<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dokumen Judul</title>

<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">Log in</div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo site_url('admin');?>">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <button type="submit" class="btn btn-primary btn-md pull-left">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
    
    <!--Modal dokumen-->
    <div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Keluar</button>
                <h4 class="modal-title" id="myModalLabel">Detail Dokumen</h4>
                </div>
                <div class="modal-body">
                    <h4 id="judul_dok" class="text-center"></h4>
                    <h4 id="nama_dok" class="text-center"></h4>
                    <h4 id="tahun_dok" class="text-center"></h4>
                    <h5 id="abstrak_dok" class=""></h5>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
      </div>
    </div>
        
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chart-data.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/easypiechart.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-table.js"></script>
    <script>
            !function ($) {
                    $(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
                            $(this).find('em:first').toggleClass("glyphicon-minus");	  
                    }); 
                    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
              if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
              if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
            })
            
            // Ajax post detail
            $(document).ready(function() {
                $(".detail").click(function(event) {
                    event.preventDefault();
                    var id = $(this).data('nilai');
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/dokumen/tampil_detail",
                        dataType: 'json',
                        data: {id: id},
                        success: function(res) {
                            $('#judul_dok').html("<p>"+res[0][0]+"</p>");  
                            $('#tahun_dok').html("<p>"+res[1][0]+" - "+res[3][0]+" - "+res[4][0]+"</p>");     
                            $('#nama_dok').html("<p>"+res[2][0]+"</p>");   
                            $('#abstrak_dok').html("<p>"+res[5][0]+"</p>");   
                        }
                    });
                });
            });
    </script>
</body>
</html>

