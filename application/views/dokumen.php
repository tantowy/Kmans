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
    <?php include 'header.php';?>
    <?php include 'menuBar.php';?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="active">Dokumen Judul</li>
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
                        Form Dokumen Judul
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action=<?php echo site_url('dokumen/insert_dokumen');?> >
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Judul :</label>
                                <div class="col-md-9">
                                    <input id="judul" name="judul" type="text" placeholder="Judul" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Tahun Judul :</label>
                                <div class="col-md-4">
                                    <input id="tahun" name="tahun" type="text" placeholder="Tahun" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Nama/Fak/Jurusan :</label>
                                <div class="col-md-3">
                                    <input id="nama" name="nama" type="text" placeholder="Nama Mahasiswa" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input id="fakultas" name="fakultas" type="text" placeholder="Fakultas" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input id="jurusan" name="jurusan" type="text" placeholder="Jurusan" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="message">Astrak :</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="message" name="abstrak" placeholder="Abstrak..." rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">URL :</label>
                                <div class="col-md-4">
                                    <input id="url" name="url" type="text" placeholder="URL" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="message"></label>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-md pull-left">Simpan Judul</button>
                                </div>
                            </div>
                        </form>
                        
                        <button class="btn btn-default col-md-12" data-toggle="collapse" href="#tabelDokumen">Lihat Tabel Dokumen Judul <span class="glyphicon glyphicon-search"></span></button>
                        <div class="row children collapse" id="tabelDokumen">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Tabel Dokumen</div>
                                    <div class="panel-body">
                                        <table data-toggle="table" data-url="" data-pagination="true">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul</th>
                                                    <th>Tahun</th>
                                                    <th>Detail</th>
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
                                                        <td>".$value->dokumen_tahun."</td>
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

