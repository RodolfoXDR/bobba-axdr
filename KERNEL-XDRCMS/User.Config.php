<?php
const HotelName = 'Bobba';
const LongName = HotelName . ' Hotel';
const HomeRoomId = 7168;

$config['SQL'] = [
	'api' => 'mysqli', // mysqli or pdo
	'host' => '127.0.0.1',
	'port' => 3306,
	'userName' => 'root',
	'passWord' => 'Azure',
	'dbName' => 'xukys'
];

$config['URL'] = [
	'default' => ['requireWWW' => false, // www.example.com
		'requireSSL' => false, // https://
		'server' => 'localhost', // url principal, sin www., no poner localhost, para eso ya está devPrivateServer.
		'lang' => 'es_ES' // GLOBAL.
	],
	'127.0.0.1' => ['requireWWW' => false, // www.example.com
		'requireSSL' => false, // https://
		'server' => '', // url principal, sin www., no poner localhost, para eso ya está devPrivateServer.
		'lang' => 'es_ES' // GLOBAL.
	],
	'devPrivateServer' => 'localhost',	// servidor privado de desarrollo - NO TOCAR
	'style' => 'Habbo',
	'dirASE' => '/ase', //BETA ALL SEEING EYE DIRECTORY
	'dirUploads' => 'C:/inetpub/Xukys/wwwroot/swf/' //SWFs Directory
];

class Config
{
	const OnlineType = 1;
	const CacheEnabled = true;
	const OfflineMode = false;
	
	public static $Restrictions = [
		'maintenance' => [
			'active' => false, // false -> desactivado, true -> activado
			'except' => 2, // rango minimo para saltarse el manteminiento.
			'twitter' => 'habbo', // nombre de twitter, sin @
			'twitterCount' => 3 // twitts a mostrar.
		],
		'country' => [
			'action' => 0, // 0 -> Desactivado (Todo el mundo puede acceder), 1 -> Bloquear (Los paises que esten en la lista no pueden entrar), 2-> Permitir (Solo los paises que esten en la lista pueden entrar)
			'strict' => true, // true -> Si ocurre un error (Que no encuentra el pais), no te deja pasar. false -> Desactivado.
			'list' => ['ES', 'US']
		],
		'security' => [
			'secretKeys' => [
				'enabled' => false,
				'keys' => [1 => '03555'] // userID => KEY(min-max length 5)
			]
		]
	];

	public static $Server = [
		'server' => [
			'name' => 'Plus',
			'camera' => false
		]
	];
	
	public static $FaceBook = [
		'app' => [
			'id' => '656533071187201',
			'privateID' => '150e19e3b1c47270905214ccf8260ba0',
			'name' => 'Xukysv2' // App Name
		],
		'page' => [
			'name' => 'Xukys Hotel',
			'url' => 'https://www.facebook.com/Xukysv2'
		]
	];

	public static $ReCaptcha = [
		'options' => [
			'CURLOPT_SSL_VERIFYPEER' => false
		],
		'data' => [
			'siteKey' => '6LdeqFsUAAAAAHNEkqlaD3ylMuN82VXH3IYM0gzu',
			'secretKey' => '6LdeqFsUAAAAAIbTuHo0fS2qCmqlYlqnaCnuqg2i'
		]
	];
	
	public static $SMTP = [
		'host' => '127.0.0.1',
		'port' => 25,
		'mail' => 'mail@xukys-hotel.com', // Dejar en blanco para desactivar autentificación
		'passWord' => 'Yuut9$mxpps0m2m5jaje'
	];

	public static $Vouchers = ['tableName' => 'vouchers',
		'coinColumn' => 'type',
		'codeColumn' => 'voucher',
		'valueColumn' => 'value',
		'types' => [
			'CREDIT' => 'credits'
		]
	];
	
	public static $AXMS = [
		'host' => '', // Dejar en blanco para desactivar
		'port' => 25,
		'user' => 'localhost',
		'passWord' => ''
	];
}
?>