<?php
class Categories {
	public static $Row = [
		66 => ['Name' => 'Banderas', 'MinRank' => 1],
		55 => ['Name' => 'Alfabeto Madera', 'MinRank' => 1],
		56 => ['Name' => 'Alfabeto Diner Azul', 'MinRank' => 1],
		60 => ['Name' => 'Alfabeto Diner Verde', 'MinRank' => 1],
		61 => ['Name' => 'Alfabeto Diner Rojo', 'MinRank' => 1],
		27 => ['Name' => 'Trax', 'MinRank' => 1],
		29 => ['Name' => 'Alfbeto Plastic', 'MinRank' => 1],
		30 => ['Name' => 'Alfabeto Bling', 'MinRank' => 1],
		31 => ['Name' => 'Construcción', 'MinRank' => 1],
		32 => ['Name' => 'Locuras', 'MinRank' => 1],
		33 => ['Name' => 'Maravillas', 'MinRank' => 1],
		34 => ['Name' => 'Terror', 'MinRank' => 1],
		35 => ['Name' => 'Ofertas', 'MinRank' => 1],
		36 => ['Name' => 'Flechas', 'MinRank' => 1],
		37 => ['Name' => 'Plantas', 'MinRank' => 1],
		38 => ['Name' => 'Efectos', 'MinRank' => 1],
		39 => ['Name' => 'SnowStorm', 'MinRank' => 1],
		40 => ['Name' => 'BattleBall', 'MinRank' => 1],
		42 => ['Name' => 'Personalidades', 'MinRank' => 1],
		44 => ['Name' => 'Otros', 'MinRank' => 1],
		1 => ['Name' => 'Otros 1(Staff)', 'MinRank' => 6],
		2 => ['Name' => 'Otros 1(Staff)', 'MinRank' => 1],
		3 => ['Name' => 'Letras(Staff)', 'MinRank' => 1]
	];
	
	public static $Skins = [
		1 => ['Skin' => 'n_skin_defaultskin', 'MinRank' => 1],
		2 => ['Skin' => 'n_skin_speechbubbleskin', 'MinRank' => 1],
		3 => ['Skin' => 'n_skin_metalskin', 'MinRank' => 1],
		4 => ['Skin' => 'n_skin_noteitskin', 'MinRank' => 1],
		5 => ['Skin' => 'n_skin_notepadskin', 'MinRank' => 1],
		6 => ['Skin' => 'n_skin_goldenskin', 'MinRank' => 1],
		7 => ['Skin' => 'n_skin_hc_machineskin', 'MinRank' => 1],
		8 => ['Skin' => 'n_skin_hc_pillowskin', 'MinRank' => 1],
		9 => ['Skin' => 'n_skin_nakedskin', 'MinRank' => 1],
	];

	public static function GetItem($c, $i) {
		return SQL::query('SELECT * FROM xdrcms_store_items WHERE id = ' . $i . ' AND categoryId = ' . $c);
	}

	public static function GetItems($c) {
		return SQL::query('SELECT * FROM xdrcms_store_items WHERE categoryId = ' . $c);
	}
}
?>