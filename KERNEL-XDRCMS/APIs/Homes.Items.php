<?php
class Item {
	public static function Create($i, $v, $s, $t)
	{
		SQL::query('INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES (' . $i . ', \'' . $v . '\', \'' . $s . '\', \'' . $t . '\')');
	}
	
	public static function Place($h, $g, $pl, $pt, $pz, $v, $s, $c, $t) {
		SQL::query('INSERT INTO xdrcms_site_items (userId, groupId, position_left, position_top, position_z, var, skin, content, type) 
			VALUES (' . $h . ', ' . $g . ', ' . $pl . ', ' . $pt . ', ' . $pz . ', \'' . $v . '\', \'' . $s . '\', \'' . $c . '\', \'' . $t . '\')');
	}
	
	public static function Update($t, $c) { //$t>d|s|t
		$q = 'UPDATE xdrcms_site_items SET ';
		if($t === 'd'):
			$q .= ' userId = ' . $c[1] . ', groupId = ' . $c[2] . ', position_left = ' . $c[3] . ', position_top = ' . $c[4] . ', position_z = ' . $c[5] . '';
		elseif($t === 's'):
			$q .= ' userId = ' . $c[1] . ', groupId = ' . $c[2] . ', skin = \'' . $c[3] .'\'';
		elseif($t === 't'):
			$q .= ' Temporal = \'False\'';
		endif;

		$q .= ' WHERE id = ' . $c[0] . ' LIMIT 1';
		SQL::query($q);
	}

	public static function restoreWaiting($i) {
		SQL::query('UPDATE xdrcms_site_inventory_items SET isWaiting = \'0\' WHERE userId = ' . $i);
	}
	
	public static function removeWaiting($i, $I) {
		SQL::query('DELETE FROM xdrcms_site_inventory_items WHERE userId = ' . $i . ' AND id = ' . $I . ' AND isWaiting = \'1\' LIMIT 1');
	}
}
?>