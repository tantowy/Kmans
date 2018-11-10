<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clustering Dokumen</title>

<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php';?>
    <?php include 'menuBar.php';?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="active">Clustering Dokumen</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <br>
            </div>
        </div><!--/.row-->
            
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Clustering Dokumen
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                
                                <?php
                                $k = 1;
                                foreach($konfig as $konfig_value){
                                    $k = $konfig_value->jml_cluster;
                                }
                                ?>
                                
                                <div class="panel panel-default">
                                     <div class="panel-heading">Hitung Clustering Kmeans</div>
                                     <div class="panel-body">
                                         <form class="form-horizontal" method="post" action=<?php echo site_url('kmeans');?> >
                                             <div class="form-group">
                                                <div class="col-md-6">
                                                    <input id="k_means" name="k_means" type="text" placeholder="K Value" class="form-control" value="<?php echo $k; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary btn-md pull-left">Hitung Cluster</button>
                                                </div>
                                            </div>
                                         </form>
                                     </div>
                                </div>
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading">Hasil Clustering Kmeans</div>
                                    <div class="panel-body" style="overflow-y: auto">
                                        <div>
                                            <button class="btn btn-default col-md-12" data-toggle="collapse" href="#detailKmeans"><b> Lihat Detail Clustering Kmeans </b><span class="glyphicon glyphicon-search"></span></button>
                                        </div>
                                        <br><br>
                                        <div class="collapse" id="detailKmeans">
                                           <?php 
                                            echo $mod_clustering;
                                            ?> 
                                        </div>
                                        <div>
                                            <button class="btn btn-default col-md-12" data-toggle="collapse" href="#dokumenCluster"><b> Lihat Dokumen Cluster </b><span class="glyphicon glyphicon-search"></span></button>
                                        </div>
                                        <br><br>
                                        <div class="collapse" id="dokumenCluster">
                                            <table data-toggle="table" data-url="" data-pagination="true">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul</th>
                                                        <th>Cluster</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $no = 1;
                                                        foreach($mod_dokumen_cluster as $value){
                                                            echo '<tr>';
                                                            echo '<td>'.$no.'</td>';
                                                            echo '<td>'.$value->dokumen_judul.'</td>';
                                                            echo '<td>'.$value->cluster.'</td>';
                                                            echo '</tr>';
                                                            $no++;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/.row-->	
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>	<!--/.main-->
        
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
    </script>
</body>
</html>

