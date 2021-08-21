<?php
$PageName = 'Principal';

$s = Cache::GetStats();
$sSettings = Cache::GetAIOConfig('Server');
Site::SetOnline();

require ASE . 'Header.html';
?>

		<div class="row4">
			<div class="cell">
				<div class="tile bird blue">
					<div id="information"><a href="<?php echo URL; ?>/client"><?php echo Site::$Onlines; ?></a> Onlines</div>
				</div>
			</div>
			<div class="cell">
				<div class="tile bird red">
					<div id="information"><a href="<?php echo HHURL; ?>/manage?p=users"><?php echo $s[0]; ?></a> Registrados</div>
				</div>
			</div>
			<div class="cell">
				<div class="tile bird orange">
					<div id="information"><a href="<?php echo HHURL; ?>/manage?p=users&filter=3c212d2d20747970653a62616e73202d2d3e"><?php echo $s[2]; ?></a> Baneados</div>
				</div>
			</div>
			<div class="cell">
				<div class="tile bird green">
					<div id="information"><a href="<?php echo HHURL; ?>/manage?p=users&filter=3c212d2d206d696e72616e6b202d2d3e"><?php echo $s[1]; ?></a> Staffs</div>
				</div>
			</div>
		</div>
		<div class="row1">
			<div class="cell">
				<div id="avatar">
			
					<div id="welcome_message">
						Bienvenid@, <?php echo User::$Data['name']; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row3">
			<div class="cell">
				<div class="panel flat chart red">
					<div id="header">Historial de Onlines</div>
					<div id="content">
						<div id="ServerPeaks"></div>
					</div>
				</div>
			</div>
			<div class="cell">
				<div class="panel blue">
					<div id="header">Staffs Conectados</div>
					<div id="content" style="height: 225px;overflow-y: scroll;">
						<table class="staff__panel">
							<tbody>
								<?php 
									$Query = SQL::query("SELECT " . Server::Get(Server::USER_NAME_COLUMN) . ", online, " . Server::Get(Server::USER_LOOK_COLUMN) . " FROM " . Server::Get(Server::USER_TABLE) . " WHERE rank > 1 AND online = '1'");
									if($Query && $Query->num_rows > 0):
										while ($uRow = $Query->fetch_assoc()):
								?>
								<tr>	
									<td>
										<div class="base">
											<img src="<?php echo LOOK . $uRow[Server::Get(Server::USER_LOOK_COLUMN)]; ?>&direction=3&head_direction=3&gesture=sml&headonly=1" />
										</div>
									</td>
									<td>
										<?php echo $uRow[Server::Get(Server::USER_NAME_COLUMN)]; ?>
									</td>
								</tr>
								<?php
										endwhile;
									else:
								?>
								<tr>
									<td>
										<p style="color: black;font-size: 10pt;">No hay staffs conectados.</p>
									</td>
								</tr>
								<?php 
									endif;
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="cell">
				<div class="panel green">
					<div id="header">Horarios del Servidor</div>
					<div id="content">
						<div class="time">
							<?php 
								date_default_timezone_set("America/Monterrey");
								echo 'México - Monterrey: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
						<div class="time">
							<?php 
								date_default_timezone_set("America/Chicago");
								echo 'Estados Unidos - Chicago: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
						<div class="time">
							<?php 
								date_default_timezone_set("America/Caracas");
								echo 'Venezuela - Caracas: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
						<div class="time">
							<?php 
								date_default_timezone_set("America/Argentina/Buenos_Aires");
								echo 'Argentina - Buenos Aires: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
						<div class="time">
							<?php 
								date_default_timezone_set("America/Santo_Domingo");
								echo 'Rep. Dominicana - Santo Domingo: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
						<div class="time">
							<?php 
								date_default_timezone_set("America/Bogota");
								echo 'Colombia - Bogota: <b>'.date('H:i', time()).'</b>';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="subsection">Acciones Rápidas</div>
		<div class="row3">
			<?php if(User::hasPermission('ase.give_rank')): ?>
				<div class="cell">
					<div class="panel flat chart blue">
						<div id="header">Dar Rango</div>
						<div id="content">
							<div class="input-control text" data-role="input" style="">
								<input type="text" name="userName" id="uN" placeholder="Usuario" value=""></input>
							</div>
							<div class="input-control text" data-role="input" style="">
									<select name='user.rank' id="ur" class='styled'>
									<?php $n = 1; while($n != User::$Data['rank']): if($n === MaxRank)	continue; ?>
										<option id="ur.<?php echo $n; ?>" value='<?php echo $n; ?>'><?php echo ($n === 1)? HotelName : (isset(Config::$Ranks['rights'][$n]) ? Config::$Ranks['rights'][$n][0] : $n); ?></option>
									<?php $n++; endwhile; ?>
									</select>
								</div>
								<button class="green" onclick="changeRank()">Cambiar</button>
								<br /><br />
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		
<!--END HEADER-->
	</div>
</div>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawServerPeaks);
//google.charts.setOnLoadCallback(drawCurrentLimit);

function drawServerPeaks() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Fechas');
	data.addColumn('number', 'Usuarios');
	data.addRows([
	  ['12/12/1992', 1],
	  ['12/12/1992', 1],
	  ['12/12/1992', 2],
	  ['12/12/1992', 4],
	  ['12/12/1992', 2],
	  ['12/12/1992', 7]
	]);

	var options = {
		width: "100%",
		height: "100", 
		chartArea:{
			left: "0",
			top: "0",
			width: "100%",
			height: "70" 
		},
		backgroundColor: {
			fill: 'transparent',
			stroke: 'transparent'
		},
		colors: ['#fff'],
		is3D: true,
		pointSize: 5,
		lineWidth: 2,
		hAxis: {
			gridlines: {
				color: 'transparent'
			},
			textPosition: 'none'
		},
		vAxis: {
			gridlines: {
				color: 'transparent'
			},
			textPosition: 'none'
		}
	};
	
	var chart = new google.visualization.AreaChart(document.getElementById('ServerPeaks'));
	chart.draw(data, options);
}
</script>