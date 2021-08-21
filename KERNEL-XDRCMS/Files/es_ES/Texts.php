<?php
class Texts
{
	public static $Map = [
		Text::ACP_LOGIN_EMPTY_BOTH => 'Por favor, introduce tu nombre de usuario y contraseña para conectarte.',
		Text::ACP_LOGIN_ERROR => 'Esta cuenta no existe, <br/> o has escrito algo mal. Comprueba la información.',
		Text::ACP_LOGIN_RANK => 'Esta cuenta no tiene rango.',
		Text::LOGIN_CAPTCHA => 'Por favor, introduce el código de seguridad y asegúrate de que tu email y contraseña son correctos.',
		Text::LOGIN_EMPTY_BOTH => 'Por favor, introduce tu email y contraseña para conectarte.',
		Text::LOGIN_EMPTY_NAME => 'Por favor, escribe tu email.',
		Text::LOGIN_EMPTY_PASSWORD => 'Por favor, escribe tu contraseña.',
		Text::LOGIN_ERROR => 'Tu contraseña y email no coinciden.',
		Text::BANNED => '¡Has sido baneado! La razón del baneo es: "%s". El baneo expirará el %s.',
		Text::LOGOUT => 'Te has desconectado correctamente.',
		Text::LOGOUT_ERROR => 'No te has desconectado correctamente.',
		Text::SESSION_EXPIRED => 'Sessión expirada. Has estado inactivado durante mucho tiempo.',
		Text::SESSION_CONCURRENT => 'Has sido desconectado porque te has registrado con otro navegador u ordenador.',
		Text::ACP_SECRET_KEY => 'Al parecer no has ingresado una Secret Key. Puedes navegar por la administración pero no puedes hacer cambios. Si quieres hacer cambios, favor de ingresar tu código de seguridad:',
		
		//TIME
		Text::TIME_PAST => 'Hace ',
		Text::TIME_FUTURE => 'Dentro de ',
		Text::TIME_NOW => 'Ahora mismo',
		Text::TIME_YESTERDAY => 'Ayer',
		Text::TIME_TOMORROW => 'Mañana',
		Text::TIME_SOME => 'unos ',
		Text::TIME_SECONDS => ' segundos',
		Text::TIME_MINUTE => ' minuto',
		Text::TIME_HOUR => ' hora',
		Text::TIME_DAY => ' día',
		Text::TIME_WEEK => ' semana',
		Text::TIME_MONTH => ' mes',
		Text::TIME_YEAR => ' año',
		
		//REGISTER
		Text::REGISTER_PWD_EMPTY => 'Escribe una contraseña',
		Text::REGISTER_PWD_TOO_SHORT => 'Tu contraseña debe tener al menos 6 caracteres',
		Text::REGISTER_PWD_TOO_LONG => 'Tu contraseña es muy larga',
		Text::REGISTER_PWD_NOT_NUM => 'Tu contraseña debe incluir algún número',
		Text::REGISTER_PWD_NOT_MATCH => 'Las contraseñas no coinciden',
		Text::REGISTER_TOS => 'Por favor, debes aceptar los términos',
		Text::REGISTER_COOKIES => 'Por favor, acepta la política de cookies',
		Text::REGISTER_EMAIL_NOTVALID => 'Por favor, introduce una dirección de email válida',
		Text::REGISTER_EMAIL_REGISTERED => 'El email proporcionado ya está siendo usado',
		Text::CAPTCHA_ERROR => 'Por favor, comprueba que no eres un robot',
		Text::REGISTER_NAME_EMPTY => 'Introduce un nombre',
		Text::REGISTER_NAME_TOO_SHORT => 'Tu nombre es demasiado corto para pronunciar',
		Text::REGISTER_NAME_TOO_LONG => 'Tu nombre es demasiado largo para recordar',
		Text::REGISTER_NAME_NOTVALID => 'Tu nombre solo puede tener letras y números',
		Text::REGISTER_NAME_REGISTERED => 'El nombre ya está siendo usado',
		Text::REGISTER_MYSQL_ERROR => 'Error al registrar usuario, inténtalo mas tarde',
		
		//GLOBAL ERRORS
		Text::ERROR_DEFAULT => 'Ha ocurrido un error inesperado. Inténtalo mas tarde.',
		Text::ERROR_DIFF_PWD => 'La contraseña no coincide con la antigua.',
		Text::CLIENT_BLOCKED_WRONG_PIN => 'Mal PIN',
		Text::CLIENT_BLOCKED_EMPTY_PIN => 'Ningun PIN',
		Text::CLIENT_BLOCKED_NO_PIN => 'No hay PIN',
		Text::CLIENT_BLOCKED_INVALID_PIN => 'PIN Invalido',
	];
}
?>