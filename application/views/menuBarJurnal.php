<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <span>Daftar Cluster</span>
        </div>
    </form>
    <ul class="nav menu">
        <li class="<?php echo (!isset($_GET['cluster']) || (isset($_GET['cluster']) && ($_GET['cluster'])==""))? "active" : ""?>"><a href="<?php echo (isset($_GET['data']))? site_url('jurnal?data='.$_GET['data']) : site_url('jurnal'); ?>"><span class="glyphicon glyphicon-list-alt "></span> SEMUA</a></li>
        <?php 
        if(isset($cluster)){
            $count = 1;
            foreach ($cluster as $value) {
                ?>
        <li class="<?php echo (isset($_GET['cluster']) && $_GET['cluster'] <> "" && ($_GET['cluster'])==$count)? "active" : ""?>"><a href="<?php echo (isset($_GET['data']))? site_url('jurnal?cluster='.$count.'&data='.$_GET['data']) : site_url('jurnal?cluster='.$count); ?>"><span class="glyphicon glyphicon-list-alt "></span> CLUSTER <?php echo $count;?> (<?php echo $value->jumlah;?> Dok)</a></li>
                <?php
                $count++;
            }
        }
        ?>
    </ul>
</div><!--/.sidebar-->
