<?php
class ReCaptchaRequestParameters
{
    private $secret;
    private $response;
    private $remoteIp;
    private $version;

    public function __construct($secret, $response, $remoteIp = null, $version = null)
    {
        $this->secret = $secret;
        $this->response = $response;
        $this->remoteIp = $remoteIp;
        $this->version = $version;
    }

    public function toArray()
    {
        $params = array('secret' => $this->secret, 'response' => $this->response);

        if (!is_null($this->remoteIp)) {
            $params['remoteip'] = $this->remoteIp;
        }

        if (!is_null($this->version)) {
            $params['version'] = $this->version;
        }

        return $params;
    }


    public function toQueryString()
    {
        return http_build_query($this->toArray(), '', '&');
    }
}

class ReCaptchaRequestMethod
{
    const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    public static function submit(ReCaptchaRequestParameters $params)
	{
        $handle = curl_init(self::SITE_VERIFY_URL);

        $options = array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params->toQueryString(),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            CURLINFO_HEADER_OUT => false,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => Config::$ReCaptcha['options']['CURLOPT_SSL_VERIFYPEER']
        );
        curl_setopt_array($handle, $options);

        $response = curl_exec($handle);
        curl_close($handle);

        return $response;
	}
}

class ReCaptcha
{
    public static function Verify($response, $remoteIp = null)
    {
        if (empty($response))
		{
            $recaptchaResponse = new ReCaptchaResponse(false, array('missing-input-response'));
            return $recaptchaResponse;
        }

        $params = new ReCaptchaRequestParameters(Config::$ReCaptcha['data']['secretKey'], $response, $remoteIp, 'php_1.1.1');
        $rawResponse = ReCaptchaRequestMethod::submit($params);
        return ReCaptchaResponse::fromJson($rawResponse);
    }
}

class ReCaptchaResponse
{
    private $success = false;
    private $errorCodes = array();


    public static function fromJson($json)
    {
        $responseData = json_decode($json, true);

        if (!$responseData)
            return new ReCaptchaResponse(false, array('invalid-json'));

        if (isset($responseData['success']) && $responseData['success'] == true)
            return new ReCaptchaResponse(true);

        if (isset($responseData['error-codes']) && is_array($responseData['error-codes']))
            return new ReCaptchaResponse(false, $responseData['error-codes']);

        return new ReCaptchaResponse(false);
    }

    public function __construct($success, array $errorCodes = array())
    {
        $this->success = $success;
        $this->errorCodes = $errorCodes;
    }

    public function IsSuccess()
    {
        return $this->success;
    }

    public function getErrorCodes()
    {
        return $this->errorCodes;
    }
}
?>