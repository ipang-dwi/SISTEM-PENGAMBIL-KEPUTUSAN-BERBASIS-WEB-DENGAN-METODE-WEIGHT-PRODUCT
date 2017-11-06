<?php
	session_start();
	include('configdb.php');
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php echo $_SESSION['judul']." - ".$_SESSION['by'];?></title>
	
    <!-- Bootstrap core CSS -->
    <!--link href="ui/css/bootstrap.css" rel="stylesheet"-->
	<link href="ui/css/cerulean.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="ui/css/jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--script src="./index_files/ie-emulation-modes-warning.js"></script-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
	
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $_SESSION['judul'];?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="kriteria.php">Data Kriteria</a></li>
              <li><a href="alternatif.php">Data Alternatif</a></li>
			  <li><a href="analisa.php">Analisa</a></li>
              <li class="active"><a href="#">Perhitungan</a></li>
			</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
		<div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Perhitungan</div>
		  <div class="panel-body">
			<center>
				<?php
					echo "<b>Matrix Alternatif - Kriteria</b></br>";
					
					$alt = get_alternatif();
					$alt_name = get_alt_name();
					end($alt_name); $arl2 = key($alt_name)+1; //new
					$kep = get_kepentingan();
					$cb = get_costbenefit();
					$k = jml_kriteria();
					$a = jml_alternatif();
					$tkep = 0;
					$tbkep = 0;
					
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> matrix alternatif/kriteria <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th>Alternatif / Kriteria</th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						echo "<tr><td><b>A".($i+1)."</b></td>";
						for($j=0;$j<$k;$j++){
							echo "<td>".$alt[$i][$j]."</td>";
						}
						echo "</tr>";
					}
					echo "</table><hr>";
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> bobot kepentingan <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					echo "<b>Perhitungan Bobot Kepentingan</b></br>";
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th></th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th><th>Jumlah</th></tr></thead>";
						echo "<tr><td><b>Kepentingan</b></td>";
						for($i=0;$i<$k;$i++){
							$tkep = $tkep + $kep[$i];
							echo "<td>".$kep[$i]."</td>";
						}
						echo "<td>".$tkep."</td></tr>";
						echo "<tr><td><b>Bobot Kepentingan</b></td>";
						for($i=0;$i<$k;$i++){
							$bkep[$i] = ($kep[$i]/$tkep);
							$tbkep = $tbkep + $bkep[$i];
							echo "<td>".round($bkep[$i],6)."</td>";
						}
						echo "<td>".$tbkep."</td></tr>";
					echo "</table><hr>";
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> pangkat <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					echo "<b>Perhitungan Pangkat</b></br>";
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th></th><th>K1</th><th>K2</th><th>K3</th><th>K4</th><th>K5</th></tr></thead>";
						echo "<tr><td><b>Cost/Benefit</b></td>";
						for($i=0;$i<$k;$i++){
							echo "<td>".ucwords($cb[$i])."</td>";
						}
						echo "</tr>";
						echo "<tr><td><b>Pangkat</b></td>";
						for($i=0;$i<$k;$i++){
							if($cb[$i]=="cost"){
								$pangkat[$i] = (-1) * $bkep[$i];
								echo "<td>".round($pangkat[$i],6)."</td>";
							}
							else{
								$pangkat[$i] = $bkep[$i];
								echo "<td>".round($pangkat[$i],6)."</td>";
							}
						}
						echo "</tr>";
					echo "</table><hr>";
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> vektor S <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					echo "<b>Perhitungan Nilai S</b></br>";
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th>Alternatif</th><th>S</th></tr></thead>";
					for($i=0;$i<$a;$i++){
						echo "<tr><td><b>A".($i+1)."</b></td>";
						for($j=0;$j<$k;$j++){
							$s[$i][$j] = pow(($alt[$i][$j]),$pangkat[$j]);
						}
						$ss[$i] = $s[$i][0]*$s[$i][1]*$s[$i][2]*$s[$i][3]*$s[$i][4];
						echo "<td>".round($ss[$i],6)."</td></tr>";
					}
					echo "</table><hr>";
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> vektor S <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					echo "<b>Hasil Akhir</b></br>";
					echo "<table class='table table-striped table-bordered table-hover'>";
					echo "<thead><tr><th>Alternatif</th><th>V</th></tr></thead>";
					$total = 0;
					for($i=0;$i<$a;$i++){
						$total = $total + $ss[$i];
					}
					for($i=0;$i<$a;$i++){
						echo "<tr><td><b>".$alt_name[$i]."</b></td>";
						$v[$i] = round($ss[$i]/$total,6);
						echo "<td>".$v[$i]."</td></tr>";
					}
					echo "</table><hr>";
					// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> vektor S <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< //
					uasort($v,'cmp');
								for($i=0;$i<$arl2;$i++){ //new for 8 lines below
									if($i==0)
										echo "<div class='alert alert-dismissible alert-info'><b><i>Dari tabel tersebut dapat disimpulkan bahwa ".$alt_name[array_search((end($v)), $v)]." mempunyai hasil paling tinggi, yaitu ".current($v);
									elseif($i==($arl2-1))
										echo "</br>Dan terakhir ".$alt_name[array_search((prev($v)), $v)]." dengan nilai ".current($v).".</i></b></div>";
									else
										echo "</br>Lalu diikuti dengan ".$alt_name[array_search((prev($v)), $v)]." dengan nilai ".current($v);
								}
					
										function jml_kriteria(){	
											include 'configdb.php';
											$kriteria = $mysqli->query("select * from kriteria");
											return $kriteria->num_rows;
										}
										
										function jml_alternatif(){	
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											return $alternatif->num_rows;
										}
										
										function get_kepentingan(){
											include 'configdb.php';
											$kepentingan = $mysqli->query("select * from kriteria");
											if(!$kepentingan){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $kepentingan->fetch_assoc()) {
												@$kep[$i] = $row["kepentingan"];
												$i++;
											}
											return $kep;
										}
										
										function get_costbenefit(){
											include 'configdb.php';
											$costbenefit = $mysqli->query("select * from kriteria");
											if(!$costbenefit){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $costbenefit->fetch_assoc()) {
												@$cb[$i] = $row["cost_benefit"];
												$i++;
											}
											return $cb;
										}
										
										function get_alt_name(){
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											if(!$alternatif){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $alternatif->fetch_assoc()) {
												@$alt[$i] = $row["alternatif"];
												$i++;
											}
											return $alt;
										}
										
										function get_alternatif(){
											include 'configdb.php';
											$alternatif = $mysqli->query("select * from alternatif");
											if(!$alternatif){
												echo $mysqli->connect_errno." - ".$mysqli->connect_error;
												exit();
											}
											$i=0;
											while ($row = $alternatif->fetch_assoc()) {
												@$alt[$i][0] = $row["k1"];
												@$alt[$i][1] = $row["k2"];
												@$alt[$i][2] = $row["k3"];
												@$alt[$i][3] = $row["k4"];
												@$alt[$i][4] = $row["k5"];
												$i++;
											}
											return $alt;
										}
										
										function cmp($a, $b){
											if ($a == $b) {
												return 0;
											}
											return ($a < $b) ? -1 : 1;
										}

										function print_ar(array $x){	//just for print array
											echo "<pre>";
											print_r($x);
											echo "</pre></br>";
										}
				?>
			</center>
		  </div>
		  <div class="panel-footer text-primary"><?php echo $_SESSION['by'];?><div class="pull-right"></div></div>
		</div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="ui/js/jquery-1.10.2.min.js"></script>
	<script src="ui/js/bootstrap.min.js"></script>
	<script src="ui/js/bootswatch.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="ui/js/ie10-viewport-bug-workaround.js"></script>

</body></html>