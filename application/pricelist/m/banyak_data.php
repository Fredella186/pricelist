<?php

 include "../plfp-backedit/connect.php";
 buka_koneksi();


    $jml   = mysql_query("Select count(*) as ttl From tb_pricelist where status_view = 1 ");
    $ttl   = mysql_fetch_assoc($jml);
    echo $ttl['ttl'];
 ?>