<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Teks Processing & Pembobotan</title>

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
                <li class="active">Teks Processing & Pembobotan</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <br>
            </div>
        </div><!--/.row-->
        <?php if(isset($jumlah_iddoc_insteam)){ 
                if($jumlah_iddoc_insteam<=0){?>
                    <div class="alert bg-success" role="alert">
                        <span class="glyphicon glyphicon-info-sign"></span> Tidak ada dokumen baru untuk dilakukan Teks Processing <a href="#" class="pull-right"></a>
                    </div>
        <?php }else{?>
            <div class="alert bg-warning" role="alert">
                <span class="glyphicon glyphicon-info-sign"></span> Ada dokumen yg belum dilakukan Teks Processing sebanyak <b><?php echo $jumlah_iddoc_insteam; ?></b> <a href="#" class="pull-right"></a>
            </div>
            <div class="row">
            <div class="col-md-12">
            <a href="<?php echo site_url('teksProcessing/Processing_text'); ?>"><button class="btn btn-primary col-md-12" >Lakukan Teks Processing <span class="glyphicon glyphicon-filter"></span></button></a>
            </div>
            </div><br>
        <?php       }
              }?>
            
            <div class="row">
            <div class="col-md-12">
            <a href="<?php echo site_url('teksProcessing/Bobot_tfidf'); ?>"><button class="btn btn-primary col-md-12" >Lakukan Pembobotan Weight Tf-Idf Dokumen <span class="glyphicon glyphicon-stats"></span></button></a>
            </div>
            </div><br>
            
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Weight Tf-Idf Dokumen
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading">Tabel Weight Tf-Idf Dokumen</div>
                                    <div class="panel-body">
                                        <table data-toggle="table" data-url="" data-pagination="true">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul Jurnal</th>
                                                    <th>Weight Tf-Idf</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach($mod_dokumen_tfidf as $value){
                                                    echo '<tr>';
                                                        echo '<td>'.$no.'</td>';
                                                        echo '<td>'.$value->dokumen_judul.'</td>';
                                                        echo '<td>'.round($value->tfidf,3).'</td>';
                                                    echo '</tr>';
                                                    $no++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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

