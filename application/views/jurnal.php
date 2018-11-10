<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pencarian Jurnal</title>

<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'headerJurnal.php';?>
    <?php include 'menuBarJurnal.php';?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
        <div class="row">
            <div class="col-lg-12">
                <br>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <?php
                        if(isset($_GET['cluster']) && !isset($_GET['data'])){
                            $url = site_url('jurnal?cluster='.$_GET['cluster']);
                            $isiData = "";
                            $cluster = $_GET['cluster'];
                        }else if(isset($_GET['cluster']) && isset($_GET['data'])){
                            $url = site_url('jurnal?cluster='.$_GET['cluster'].'&data='.$_GET['data']);
                            $isiData = $_GET['data'];
                            $cluster = $_GET['cluster'];
                        }else if(isset($_GET['data']) && !isset($_GET['cluster'])){
                            $url = site_url('jurnal');
                            $isiData = $_GET['data'];
                            $cluster = null;
                        }else{
                            $url = site_url('jurnal');
                            $isiData = "";
                            $cluster = null;
                        }
                        ?>
                        <form method="get" action=<?php echo $url;?>>
                            <div class="form-group has-success">
                                <input value="<?php echo $isiData;?>" class="form-control" name="data" placeholder="Masukan Pencarian Judul">
                                <input type="hidden" value="<?php echo $cluster;?>" class="form-control" name="cluster" placeholder="Masukan Pencarian..">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-info" style="min-height: 520px">
                    <div class="panel-body">
                        <table data-toggle="table" data-url="" data-pagination=<?php echo (count($dokumen)>10)? "true" : "";?>>
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JURNAL</th>
                                    <th>DETAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach($dokumen as $value) 
                                {
                                    echo "<tr>";
                                    echo "
                                        <td>".$no."</td>
                                        <td>".$value->dokumen_judul."</td>
                                        <td><a class=\"detail\" href=\"#\" data-nilai=\"".$value->dokumen_id."\" data-toggle=\"modal\" data-target=\"#basicModal1\">Detail</a></p></td>
                                        ";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>	<!--/.main-->
    
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

