<?php


class MagicFacebook {
	private $app_id;
	private $app_secret;
	private $fb;
	private $permissions;
	
	public function __construct($app_id, $app_secret, $permissions = ['email']) {
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->permissions = $permissions;
		
		$this->fb = new Facebook\Facebook([
			'app_id' => $this->app_id,
			'app_secret' => $this->app_secret,
			'default_graph_version' => 'v2.2'
		]);
	}
	
	public function getLoginUrl($callback) {
		$helper = $this->fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl($callback, $this->permissions);
		
		return $loginUrl;
	}
	
	public function getAccessToken() {
		$helper = $this->fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			return 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			return 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
		
		return $accessToken;
	}
	
	public function getUserData($accessToken, $fields = ['id', 'name', 'email']) {
		$fields_str = '';
		
		foreach ($fields as $field) {
			$fields_str .= $field . ',';
		}
		
		$fields_str = substr($fields_str, 0, -1);
		
		$response = $this->fb->get('/me?fields=' . $fields_str, $accessToken);
		$userData = $response->getGraphUser();
		
		return $userData;
	}
	
	public function postStatus($accessToken, $message) {
		$this->fb->post('/me/feed', array('message'=>$message), $accessToken);
		return true;
	}
	
	public function getSession() {
		$helper = $this->fb->getRedirectLoginHelper();
	}
	
	public function getLikes($accessToken, $uid) {
		$request = new Facebook\FacebookRequest(
			$this->fb->getApp(),
			$accessToken,
			'GET',
			'/' . $uid . '/likes'
		);
		$response = $this->fb->getClient()->sendRequest($request);
		$graphObject = $response->getGraphEdge();
		
		return $graphObject;
	}
	
	public function getFriendsData($accessToken, $uid) {
		$request = new Facebook\FacebookRequest(
			$this->fb->getApp(),
			$accessToken,
			'GET',
			'/' . $uid . '/friends'
		);
		
		$response = $this->fb->getClient()->sendRequest($request);
		$graphObject = $response->getGraphEdge();
		
		return $graphObject;
	}
};

class MagicTwitter {
	private $consumer_key;
	private $consumer_secret;
	private $connection;
	private $request_token;
	private $access_token;
	
	public function __construct($consumer_key, $consumer_secret) {
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
	}
	
	public function connect() {
		$this->connection = new Abraham\TwitterOAuth\TwitterOAuth($this->consumer_key, $this->consumer_secret);
	}
	
	public function getLoginUrl($callback) {
		$this->request_token = $this->connection->oauth("oauth/request_token", array("oauth_callback" => $callback));
		$twitter_url = $this->connection->url('oauth/authorize', array('oauth_token' => $this->request_token['oauth_token']));
		
		$_SESSION['oauth_token'] = $this->request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $this->request_token['oauth_token_secret'];
		
		return $twitter_url;
	}
	
	public function getRequestToken() {
		return $this->request_token;
	}
	
	public function doCallback($oauth_token, $oauth_verifier) {
		$request_token = [];
		$request_token['oauth_token'] = $_SESSION['oauth_token'];
		$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];	
		
		if ($_SESSION['oauth_token'] == $oauth_token) {
			$this->connection = new Abraham\TwitterOAuth\TwitterOAuth($this->consumer_key, $this->consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);	
			
			$this->access_token = $this->connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_verifier));
			
			$_SESSION['status'] = 'verified';
			$_SESSION['request_vars'] = $this->access_token;
			
			unset($_SESSION['token']);
			unset($_SESSION['token_secret']);
			
			return true;
		}
		
		return false;
	}
	
	public function getUserData() {
		return $_SESSION['request_vars'];	
	}
}

?>