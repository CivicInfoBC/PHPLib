<?php


	namespace CivicInfoBC;
	
	
	class reCAPTCHA {
	
	
		public $public_key;
		public $private_key;
		
		
		public function __construct ($public_key, $private_key) {
		
			$this->public_key=$public_key;
			$this->private_key=$private_key;
		
		}
		
		
		public function Render () {
		
?><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php
			HTML::Write($this->public_key);
?>"></script>
<noscript>
	<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php
			HTML::Write($this->public_key);
?>" height="300" width="500" frameborder="0"></iframe><br />
	<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	<input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
</noscript><?php
		
		}
		
		
		private static function kvp ($key, $value) {
		
			return rawurlencode($key).'='.rawurlencode($value);
		
		}
		
		
		public function Verify ($remote_ip, $challenge, $response) {
		
			$request=new HTTP\Request('http://www.google.com/recaptcha/api/verify');
			$request->verb='POST';
			$request->body=self::kvp(
				'privatekey',
				$this->private_key
			).'&'.self::kvp(
				'remoteip',
				$remote_ip
			).'&'.self::kvp(
				'challenge',
				$challenge
			).'&'.self::kvp(
				'response',
				$response
			);
			
			$response=$request->Execute();
			if ($response->status!==200) throw new reCAPTCHAException(
				$response->response,
				$response->status
			);
			
			$matches=Regex::Matches('/^.*?$/um',$response->body);
			
			if (count($matches)===0) throw new reCAPTCHAException(
				'reCAPTCHA response blank'
			);
			
			if ($matches[0][0]==='true') return true;
			
			if (count($matches)<2) throw new reCAPTCHAException(
				'reCAPTCHA response does not give detailed error message'
			);
			
			if ($matches[1][0]==='incorrect-captcha-sol') return false;
			
			throw new reCAPTCHAException($matches[1][0]);
		
		}
	
	
	}


?>