 <?php
$PageName = 'Filtro de Palabras';

require ASE . 'Header.html';
?>
		<div class="row3">
			<div class="cell">
				<div class="tile bird blue">
					<div id="information"><b>50</b> Palabras Filtradas</div>
				</div>
			</div>
		</div>
<table>
		<thead>
			<tr>
				<th id="th1" class="text-left">Palabra</th>
				<th id="th2" class="text-left">Reemplazo</th>
				<th id="th3" class="text-left">Estricto</th>
				<th id="th4" class="text-left">Baneable</th>
				<th id="th4" class="text-left">Opciones</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$promosQuery = SQL::query('SELECT word, replacement, strict, bannable FROM wordfilter ORDER BY word ASC LIMIT 15');

			if($promosQuery !== false && $promosQuery->num_rows > 0):
				while ($row = $promosQuery->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['word']; ?></td>
						<td class="right"><?php echo $row['replacement']; ?></td>
						<td class="right"><?php echo ($row['strict'] == '1' ? 'true' : 'false'); ?></td>
						<td class="right"><?php echo ($row['bannable'] == '1' ? 'true' : 'false'); ?></td>
						<td class="right"><a href="<?php echo HURL; ?>/manage?p=wordfilter&do=edit&key=<?php echo $row['word']; ?>">Editar</a> || <a href="<?php echo HURL; ?>/manage?p=wordfilter&do=remove&key=<?php echo $row['word']; ?>">Borrar</a></td>
					</tr>
			<?php endwhile; endif; ?>
		</tbody>
</table>