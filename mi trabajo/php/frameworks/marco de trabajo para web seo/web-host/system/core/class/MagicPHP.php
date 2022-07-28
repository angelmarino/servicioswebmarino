<?php
// MagicPHP class

class MagicPHP {
	
	private $filters = array();
	
	/*
	- Add Filter
	- 'Unpacks' a text file containing words that should be removed or
	  blocked in strings it is used against. New line = new word.
	
	$filterName     - the name of the filter, used when there are multiple
				      filters used at different points in the website.
	
	$filterPath     - where the text file containing the words is located
	                  path relative to where this file is.
	*/
	
	public function addFilter($filterName, $filterPath) {
		
		$filter = array(
			$filterName
		);
		
		// open file
		$success = true;
		$file = fopen($filterPath, "r") or $success = false;
		
		if ($success) {
		
			// sort filtered words
			while (($line = fgets($file)) !== false) {
				// remove whitespaces
				$line = trim($line);
				
				// add to filter
				array_push($filter, $line);
			}
			
			// append filter
			fclose($file);
			array_push($this->filters, $filter);
			
			return true;
		}
		
		return false;
	}
	
	/*
	- Add to Filter
	- Adds word(s) to the filter.
	
	$fileName     - The name (and path) of the filter text file to add words to.
	$words        - An array containing at least one word to add to the filter.
	*/
	
	public function addToFilter($fileName, $words) {
		$file = '';
		$newWords = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				array_push($newWords, $line);
			}
			
			fclose($f);
		}
			
		foreach ($words as $word) {
			$included = false;

			foreach ($newWords as $newWord) {
				if ($word == $newWord)
					$included = true;
			}

			if (!$included)
				array_push($newWords, $word);
		}
		
		foreach ($newWords as $newWord) {
			$file .= trim($newWord) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- Remove from Filter
	- Removes word(s) from the filter.
	
	$fileName     - The name (and path) of the filter text file to remove words from.
	$words        - An array containing at least one word to remove from the filter.
	*/
	
	public function removeFromFilter($fileName, $words) {
		$file = '';
		$newWords = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				$continue = true;
				
				foreach ($words as $word) {
					if ($word == $line)
						$continue = false;
				}
				
				if ($continue)
					array_push($newWords, $line);
			}
		} else
			return false;
		
		foreach ($newWords as $newWord) {
			$file .= trim($newWord) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- Filter String
	- Checks the string against words that are included in a certain filter.
	- NOTE: If you enter an invalid filter name then this function will return
	        false anyway and may cause some confusion.
	
	- If it returns false then the string was filtered and there was no replace string.
	
	$filterName     - the name of the filter to check the string against.
	$string         - the string to be checked for banned/filtered words.
	$strict         - true means the word just needs to contain a filtered
					  word to be blocked, false means the word must match
					  the filtered word to be blocked.
	$replace[='']   - if set, replaces the word with this word, otherwise
	                  simply returns "" AKA false.
	*/
	
	public function filterString($filterName, $string, $strict = true, $replace = '') {
		
		// get the correct filter
		$filter = null;
		
		foreach ($this->filters as $thisFilter) {
			if ($thisFilter[0] == $filterName)
				$filter = $thisFilter;
		}
		
		if ($filter == null)
			return "";
		else {
			
			$newString = "";
			
			// iterate through each word in the string
			foreach (explode(" ", $string) as $char) {
				
				$match = false;
				
				$index = 0;
				
				// iterate through each word in the filter bank
				foreach ($filter as $word) {
					if ($index > 0) {
						if ($strict) {
							// if the word contains this filtered word
							if (stripos($char, $word) !== false)
								$match = true;
						} else {
							// if the word IS this filtered word
							if (strtolower($char) == strtolower($word))
								$match = true;
						}
					}
					
					$index++;
				}
				
				if ($match) {
					if ($replace == "")
						return false;
					else
						$newString .= $replace . " ";
				} else
					$newString .= $char . " ";
			}
			
			return $newString;
		}
	}
	
	/*
	- Sanitize Input
	- Helps reduce security risks and minimalises the possibility of SQL injection.
	
	$string     - The string you wish to sanitize before entering into the database.
	$level      - The level of security:
	               > 1 = adds slashes to prevent SQL injection
				   > 2 = adds slashes + htmlspecialchars to turn HTML tags into
				         HTML entities (eg. <html> becomes &lt;html&gt;)
				   > 3 = add slashes + strip_tags to remove all HTML tags.
	*/
	
	public function sanitizeInput($string, $level = 1) {
		
		switch ($level) {
		case 1:
			$string = addslashes($string);
			break;
		case 2:
			$string = htmlspecialchars(addslashes($string));
			break;
		case 3:
			$string = strip_tags(addslashes($string));
			break;
		}
		
		return $string;
		
	}
	
	/*
	- Unsanitize Input
	- Strips slashes from the input (eg. turns dog\'s into dog's)
	
	$string     - The string you want to unsanitize.
	$multiline  - Turns \n into HTML <br />
	*/
	
	public function unsanitizeInput($string, $multiline = false) {
		
		if ($multiline)
			$string = nl2br(stripslashes($string));
		else
			$string = stripslashes($string);
		
		return $string;
		
	}
		
	/*
	- IP Banner
	- Allows you to blacklist certain IP addresses
	- You can get someone's IP with the PHP function $_SERVER['REMOTE_ADDR'];
	
	- Get IPs to ban via text file
	- Returns true if the IP is banned
	
	$fileName     - Path to the text file relative to location of this script
	                containing the IP addresses to be blacklisted separated by a new line.
	$redirectPath - Path to another page to redirect to if the user's IP is blacklisted.
					Optional, if left blank nothing will happen except return true if this
					user's IP matches a banned IP address.
	*/
	
	public function blacklist($fileName, $redirectPath = '') {
		$success = true;
		
		if (file_exists($fileName)) {
			$file = fopen($fileName, "r") or $success = false;

			$blacklisted = false;

			if ($success) {
				// get my IP
				$ip = $_SERVER['REMOTE_ADDR'];

				// sort ip addresses
				while (($line = fgets($file)) !== false) {
					// remove whitespaces
					$line = trim($line);

					// check if this IP = blacklisted IP
					if ($ip == $line)
						$blacklisted = true;
				}

				fclose($file);

				if ($blacklisted) {
					if ($redirectPath == '')
						return true;
					else {
						header('location: ' . $redirectPath);
						die();
					}
				}

			}
		}
		
		return false;
	}
	
	/*
	- Add to IP Blacklist
	- Adds multiple (or just one) ip address(es) to the blacklist.
	
	$fileName     - The path and name of the blacklist text file (include the extension .txt)
	$ipAddresses  - An array containing the IP addresses (or just address) to be blacklisted.
	*/
	
	public function addToBlacklist($fileName, $ipAddresses) {
		$file = '';
		$ips = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				array_push($ips, $line);
			}
			
			fclose($f);
		}
			
		foreach ($ipAddresses as $ipAddress) {
			$included = false;

			foreach ($ips as $ip) {
				if ($ipAddress == $ip)
					$included = true;
			}

			if (!$included)
				array_push($ips, $ipAddress);
		}
		
		foreach ($ips as $ip) {
			$file .= trim($ip) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- Remove from IP Blacklist
	- Removes multiple (or just one) ip address(es) from the blacklist.
	
	$fileName     - The path and name of the blacklist text file (include the extension .txt)
	$ipAddresses  - An array containing the IP addresses (or just address) to be removed from
	                the blacklist.
	*/
	
	public function removeFromBlacklist($fileName, $ipAddresses) {
		$file = '';
		$ips = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				$continue = true;
				
				foreach ($ipAddresses as $ipAddress) {
					if ($ipAddress == $line)
						$continue = false;
				}
				
				if ($continue)
					array_push($ips, $line);
			}
		} else
			return false;
		
		foreach ($ips as $ip) {
			$file .= trim($ip) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- IP White Lister
	- Allows you to whitelist certain IP addresses so only those IP addresses can access
	  the site.
	- Returns true if user is on the whitelist.
	  
	$fileName     - Path to the text file relative to the location of this script
	                containing the IP addresses to be whitelisted separated by a new line.
	$redirectPath - Path to another page to redirect to if the user's IP is not whitelisted.
					Optional, if left blank nothing will happen except return true if this
					user's IP matches a whitelisted IP address.
	*/
	
	public function whitelist($fileName, $redirectPath = '') {
		$success = true;
		$file = fopen($fileName, "r") or $success = false;
		
		$whitelisted = false;
		
		if ($success) {
			// get my IP
			$ip = $_SERVER['REMOTE_ADDR'];
			
			// sort ip addresses
			while (($line = fgets($file)) !== false) {
				// remove whitespaces
				$line = trim($line);
				
				// check if this IP = whitelisted IP
				if ($ip == $line)
					$whitelisted = true;
			}
			
			fclose($file);
			
			if (!$whitelisted) {
				if ($redirectPath == '')
					return false;
				else {
					header('location: ' . $redirectPath);
					die();
				}
			}
		}
		
		return true;
	}
	
	/*
	- Add to IP Whitelist
	- Adds multiple (or just one) ip address(es) to the whitelist.
	
	$fileName     - The path and name of the whitelist text file (include the extension .txt)
	$ipAddresses  - An array containing the IP addresses (or just address) to be whitelisted.
	*/
	
	public function addToWhitelist($fileName, $ipAddresses) {
		$file = '';
		$ips = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				array_push($ips, $line);
			}
			
			fclose($f);
		}
			
		foreach ($ipAddresses as $ipAddress) {
			$included = false;

			foreach ($ips as $ip) {
				if ($ipAddress == $ip)
					$included = true;
			}

			if (!$included)
				array_push($ips, $ipAddress);
		}
		
		foreach ($ips as $ip) {
			$file .= trim($ip) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- Remove from IP Whitelist
	- Removes multiple (or just one) ip address(es) from the whitelist.
	
	$fileName     - The path and name of the whitelist text file (include the extension .txt)
	$ipAddresses  - An array containing the IP addresses (or just address) to be removed from
	                the whitelist.
	*/
	
	public function removeFromWhitelist($fileName, $ipAddresses) {
		$file = '';
		$ips = array();
		
		if (file_exists($fileName)) {
			$f = fopen($fileName, "r");
			
			while (($line = fgets($f)) !== false) {
				$line = trim($line);
				$continue = true;
				
				foreach ($ipAddresses as $ipAddress) {
					if ($ipAddress == $line)
						$continue = false;
				}
				
				if ($continue)
					array_push($ips, $line);
			}
		} else
			return false;
		
		foreach ($ips as $ip) {
			$file .= trim($ip) . PHP_EOL;
		}
		
		$f = fopen($fileName, "w+");
		fwrite($f, $file);
		fclose($f);
		
		return true;
	}
	
	/*
	- Password Encoder
	- Encodes a password so it cannot be converted back into plain text by anyone
	  that has access to the database.
	  
	$password     - The plain text password that was entered by the user for encoding
	$salt         - Optional but recommended, "salts" the password to make it even harder
	                to be decoded. Can be generated with the function generateSalt()
	$hashType     - Default is sha512, the hashing algorithm to use between:
	                sha1, sha256, sha512, ripemd160
	*/
	
	public function encodePassword($password, $salt = '', $hashType = 'sha512') {
		if ($hashType != "sha1" && $hashType != "sha256" && $hashType != "sha512"
			&& $hashType != "ripemd160")
			$hashType = "sha512";
		
		if ($salt == '')
			$password = hash($hashType, $password);
		else
			$password = hash($hashType, $salt . $password . $salt);
		
		return $password;
	}
	
	/*
	- Salt Generator
	- Generates salt which can be added to an encrypted password to make it harder to
	  decrypt. You will need to store the salt in a column in the user's row on the
	  database for when you check the password is correct when the user logs in again.
	*/
	
	public function generateSalt() {
		$salt = hash("sha1", rand() . rand() . rand());
		return $salt;
	}
	
	/*
	- Random Password Generator
	- Generates a password at random given specified limitations.
	
	$length               - The amount of characters the password should have.
	$useCapitalLetters    - Should the password consist of capital letters?
	$useNumbers           - Should the password consist of numbers?
	$useSpecialCharacters - Should the password consist of special characters?
	*/
	
	public function randomPassword($length = 7, $useCapitalLetters = true, $useNumbers = true, $useSpecialCharacters = true) {
		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
			'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
			'y', 'z');
		
		$specialChars = array(
			'!', '%', '^', '&', '*', '(', ')', '@');
				
		$pass = '';
		
		for ($i = 0; $i < $length; $i++) {
			$rand = rand(0, 3);
			
			switch ($rand) {
			case 0:
				$pass .= $chars[rand(0, count($chars) - 1)];
				break;
			case 1:
				if ($useCapitalLetters)
					$pass .= strtoupper($chars[rand(0, count($chars) - 1)]);
				else
					$pass .= $chars[rand(0, count($chars) - 1)];
				
				break;
			case 2:
				if ($useNumbers)
					$pass .= rand(0, 9);
				else
					$pass .= $chars[rand(0, count($chars) - 1)];
				
				break;
			case 3:
				if ($useSpecialCharacters)
					$pass .= $specialChars[rand(0, count($specialChars) - 1)];
				else
					$pass .= $chars[rand(0, count($chars) - 1)];
				
				break;
			}
		}
		
		return $pass;
	}
	
	/*
	- Pin Generator
	- Generates an x-digit pin number. The pin number never starts with 0.
	- Can be converted to an integer with php's intval() function.
	
	$length     - The amount of digits the pin number should have.
	*/
	
	public function generatePin($length = 4) {
		$pin = '';
		
		for ($i = 0; $i < $length; $i++) {
			if ($i == 0)
				$pin .= rand(1, 9);
			else
				$pin .= rand(0, 9);
		}
		
		return $pin;
	}
	
	/*
	- Username validator
	- Ensures a username entered on registration meets specific requirements. 
	- If it returns 0 that means it passed
	- If it returns 1 that means the username contains less than the min characters
	- If it returns 2 that means the username contains more than the max characters
	- If it returns 3 that means the username contains whitespaces (when not permitted)
	- If it returns 4 that means the username contains special characters (when not permitted)
	- If it returns 5 that means the username contains numbers (when not permitted)
	
	$username          - The username to be validated
	$minChars          - Minimum amount of characters permitted in the username
	$maxChars          - Maximum amount of characters permitted in the username
	$whiteSpaces       - Can the username contain whitespaces?
	$specialCharacters - Can the username contain special characters? (eg. !"£$%^)
	$numbers           - Can the username contain numbers?
	*/
	
	public function validateUsername($username, $minChars = 3, $maxChars = 20, $whiteSpaces = false, $specialCharacters = false, $numbers = true) {
		$valid = 0;
		
		if (strlen($username) < $minChars)
			$valid = 1;
		elseif (strlen($username) > $maxChars)
			$valid = 2;
		elseif (preg_match("/\s/", $username) && !$whiteSpaces)
			$valid = 3;
		elseif (!preg_match("#^[a-zA-Z0-9]+$#", $username) && !$specialCharacters)
			$valid = 4;
		elseif (preg_match("([0-9])", $username) && !$numbers)
			$valid = 5;
		
		return $valid;
	}
	
	/*
	- Password validator
	- Ensures a password entered on registration meets specific requirements.
	- If it returns 0 that means it passed
	- If it returns 1 that means the password has less than the minimum characters
	- If it returns 2 that means the password contains less than the minimum special characters
	- If it returns 3 that means the password contains less than the minimum numbers
	- If it returns 4 that means the password contains less than the minimum capital letters
	
	$password               - The password to validate
	$minChars               - The minimum amount of characters the password is permitted to have
	$leastSpecialCharacters - The minimum amount of special characters permitted
	$leastNumbers           - The minimum amount of numbers permitted
	$leastCapitalLetters    - The minimum amount of capital letters permitted
	*/
	
	public function validatePassword($password, $minChars = 6, $leastSpecialCharacters = 0, $leastNumbers = 0, $leastCapitalLetters = 0) {
		$valid = 0;
		
		if (strlen($password) < $minChars)
			$valid = 1;
		
		$numSpecialChars = 0;
		$numNumbers = 0;
		$numCapitalLetters = 0;
		
		// iterate through each character in password
		for ($i = 0; $i < strlen($password); $i++) {
			$char = substr($password, $i, 1);
			
			if (!preg_match("#^[a-zA-Z0-9]+$#", $char))
				$numSpecialChars++;
			elseif (preg_match("#^[A-Z]+$#", $char))
				$numCapitalLetters++;
			elseif (preg_match("#^[0-9]+$#", $char))
				$numNumbers++;
		}
		
		if ($numSpecialChars < $leastSpecialCharacters)
			$valid = 2;
		
		if ($numNumbers < $leastNumbers)
			$valid = 3;
		
		if ($numCapitalLetters < $leastCapitalLetters)
			$valid = 4;
		
		return $valid;
	}
	
	/*
	- Email validator
	- Ensures an email is valid in the format of user@example.com
	
	$email     - The email address to validate
	*/
	
	public function validateEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
		
		return false;
	}
	
	/*
	- IP validator
	- Ensures an IP address is in the valid format of example 127.0.0.1
	
	$ip     - The IP address to validate
	*/
	
	public function validateIP($ip) {
		if (filter_var($ip, FILTER_VALIDATE_IP))
			return true;
		else
			return false;
	}
	
	/*
	- Flood Checker
	- Checks that the user is not spamming or "flooding" the database.
	
	$interval     - How many seconds between each post from this IP address
	$ip           - The IP to flood check, default is the user's IP
	*/
	
	public function floodCheck($interval = 15, $ip = null) {
		$success = true;
		
		if (file_exists("Floodcheck.txt")) {
			$file = fopen("Floodcheck.txt", "r");

			if ($ip == null)
				$ip = $_SERVER['REMOTE_ADDR'];
			
			// sort each line addresses
			while (($line = fgets($file)) !== false) {
				$line = trim($line);
				$flood = explode(",", $line);	

				// check if ip matches ours
				if ($flood[0] == $ip) {
					// check if the flood check is successful
					if ((time() - $flood[1]) < $interval)
						$success = false;
				}
			}
			
			fclose($file);
		}
		
		return $success;
	}
	
	/*
	- Add to Floodcheck
	- Used when entering user input into the database to tell the Floodcheck how many
	  seconds passed since the user posted something to prevent spamming and flooding.
	
	$ip     - The IP to add to the floodcheck, default is the user's IP
	*/
	
	public function addFloodCheck($ip = null) {
		$file = fopen("Floodcheck.txt", "r");
		
		if ($ip == null)
			$ip = $_SERVER['REMOTE_ADDR'];
		
		$floodFile = '';
		$found = false;
		
		// sort each line addresses
		while (($line = fgets($file)) !== false) {
			$line = trim($line);
			$flood = explode(",", $line);
			
			// check if ip matches ours
			if ($flood[0] == $ip) {
				$found = true;
				$floodFile .= $ip . ',' . time() . '' . PHP_EOL;
			} else
				$floodFile .= $flood[0] . ',' . $flood[1] . '' . PHP_EOL;
		}
		
		if (!$found)
			$floodFile .= $ip . ',' . time() . '';
		
		fclose($file);
		
		// update flood check file
		$file = fopen("Floodcheck.txt", "w+");
		fwrite($file, $floodFile);
		fclose($file);
	}
	
	/*
	- Truncate String
	- Truncates a string to be shorter than it is, with an optional suffix.
	
	$string     - The string to be truncated.
	$length     - The number of characters the string should be truncated to.
	$suffix     - Optional, what to add at the end of the string after being truncated.
	*/
	
	public function truncate($string, $length, $suffix = '') {
		$string = substr($string, 0, $length);
		
		if ($suffix == '')
			$string .= '...';
		else
			$string .= $suffix;
		
		return $string;
	}
	
	/*
	- Time Ago (Unix)
	- Converts unix time into the human readable "x seconds/minutes/hours
	  /days/weeks/months/years ago/into the future" format
	
	$unixTime     - The time to turn into the "x time ago" format, 
	                can be generated with PHP's time() function which 
					is the number of seconds that passed since Jan 1 1970.
	*/
	
	public function timeAgoUnix($unixTime) {
		$time = time() - $unixTime;
		$suffix = 'ago';
		$prefix = '';
		
		if ($time < 0) {
			$suffix = '';
			$prefix = 'In ';
			$time = $unixTime - time();
		}
		
		$tYears = 0;
		$tMonths = 0;
		$tWeeks = 0;
		$tDays = 0;
		$tHours = 0;
		$tMinutes = 0;
		$tSeconds = 0;
		
		if ($time >= 31556926) {
			$tYears = floor($time / 31556926);
			$time = $time % 31556926;
		}
		
		if ($time >= 2592000) {
			$tMonths = floor($time / 2592000);
			$time = $time % 2592000;
		}
		
		if ($time >= 604800) {
			$tWeeks = floor($time / 604800);
			$time = $time % 604800;
		}
		
		if ($time >= 86400) {
			$tDays = floor($time / 86400);
			$time = $time % 86400;
		}
		
		if ($time >= 3600) {
			$tHours = floor($time / 3600);
			$time = $time % 3600;
		}
		
		if ($time >= 60) {
			$tMinutes = floor($time / 60);
			$time = $time % 60;
		}
		
		$tSeconds = $time;
		
		$timeAgo = '';
		
		if ($tYears > 0) {
			if ($tYears == 1)
				$timeAgo = $prefix . '1 year ' . $suffix;
			else
				$timeAgo = $prefix . $tYears . ' years ' . $suffix;
		} else {
			if ($tMonths > 0) {
				if ($tMonths == 1)
					$timeAgo = $prefix . '1 month ' . $suffix;
				else
					$timeAgo = $prefix . $tMonths . ' months ' . $suffix;
			} else {
				if ($tWeeks > 0) {
					if ($tWeeks == 1)
						$timeAgo = $prefix . '1 week ' . $suffix;
					else
						$timeAgo = $prefix . $tWeeks . ' weeks ' . $suffix;
				} else {
					if ($tDays > 0) {
						if ($tDays == 1)
							$timeAgo = $prefix . '1 day ' . $suffix;
						else
							$timeAgo = $prefix . $tDays . ' days ' . $suffix;
					} else {
						if ($tHours > 0) {
							if ($tHours == 1)
								$timeAgo = $prefix . '1 hour ' . $suffix;
							else
								$timeAgo = $prefix . $tHours . ' hours ' . $suffix;
						} else {
							if ($tMinutes > 0) {
								if ($tMinutes == 1)
									$timeAgo = $prefix . '1 minute ' . $suffix;
								else
									$timeAgo = $prefix . $tMinutes . ' minutes ' . $suffix;
							} else {
								if ($tSeconds == 1)
									$timeAgo = $prefix . '1 second ' . $suffix;
								else
									$timeAgo = $prefix . $tSeconds . ' seconds ' . $suffix;
							}
						}
					}
				}
			}
		}
		
		return $timeAgo;
	}
	
	/* 
	- Format Number
	- Formats a number with grouped thousands and decimals.
	
	$number             - The number to be formatted
	$decimals           - The number of decimals the number should have
	$thousandsSeperator - How every thousand should be seperated (usually by a comma)
	$decSeperator       - How decimals should be seperated (usually be a period)
	*/
	
	public function formatNumber($number, $decimals = 0, $thousandsSeperator = ',', $decSeperator = '.') {
		return number_format($number, $decimals, $decSeperator, $thousandsSeperator);
	}
	
	/*
	- Time Ago (String)
	- Converts string-time into the human readable "x seconds/minutes/hours
	  /days/weeks/months/years ago/into the future" format
	  
	$time     - The string-time to convert into human readable time.
				Recommended format is YYYY-MM-DD HH:MM:SS
	*/ 
	
	public function timeAgo($time) {
		$unixTime = strtotime($time);
		return $this->timeAgoUnix($unixTime);
	}
	
	/*
	- Format Date (Unix)
	- Formats unix time (number of seconds passed since January 1st, 1970 to human
	  readable time like "January 1, 2015 at 3:35pm"
	  
	$unixTime     - The time to be formatted (current time can be fetched with the php
                    function time() )
	*/
	
	public function formatDateUnix($unixTime, $dateOnly = false) {
		$formatted = date("F d, Y", $unixTime);
		
		if (!$dateOnly) {
			$formatted .= " at ";
			$formatted .= date("g:ia", $unixTime);
		}
		
		return $formatted;
	}
	
	/*
	- Format Date (String)
	- Formats string-time into the human readable format.
	
	$time     - The string-time to convert into human readable time.
	            Recommended format is YYYY-MM-DD HH:MM:SS
	*/
	
	public function formatDate($time, $dateOnly = false) {
		$unixTime = strtotime($time);
		return $this->formatDateUnix($unixTime, $dateOnly);
	}
	
	/*
	- Shorten URL (tinyurl)
	- Sends a request to tinyurl's API via cURL to shorten the specified URL
	- Returns the resulting short URL
	
	$link     - The http URL to shorten
	$timeout  - How many seconds to wait before giving up
	*/
	
	public function tinyUrl($link, $timeout = 5) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://tinyurl.com/api-create.php?url=" . $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}
	
	/*
	- Get Location (ip-api)
	- Sends a request to ip-api via cURL to get the approximate location of the specified IP
	
	$format     - What the response should look like:
	              0 => Town/City, County/State, Country
				  1 => Town/City
				  2 => County/State
				  3 => Town/City, County/State
				  4 => Country
				  5 => State Code (ie NY)
				  6 => Town/City, County/State, State Code, Country
				  7 => Array of values
				       => [0] = success or failure
					   => [1] = Country
					   => [2] = Country Code ie. GB
					   => [3] = State Code ie. NY
					   => [4] = Country/County/State
					   => [5] = Town/City
					   => [6] = Post/ZIP Code
					   => [7] = Longitude
					   => [8] = Latitude
					   => [9] = Timezone ie. Europe/London
					   => [10] = ISP
					   => [11] = ISP
					   => [12] = ISP Full Name
					   => [13] = The IP address
	
	$ip       - The IP to get the location of
	$timeout  - Number of seconds to wait before giving up
	*/
	
	public function getLocation($format = 0, $ip = '', $timeout = 5) {
		if ($ip == '')
			$ip = $_SERVER['REMOTE_ADDR'];
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/csv/" . $ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		$arr = explode(",", $data);
		
		if ($arr[0] == "success") {
			// remove speech marks
			$i = 0;
			foreach ($arr as $ari) {
				$arr[$i] = str_replace('"', '', $ari);
				$i++;
			}			
			
			if ($format == 0) {
				return $arr[5] . ', ' . $arr[4] . ', ' . $arr[1];	
			} elseif ($format == 1) {
				return $arr[5];
			} elseif ($format == 2) {
				return $arr[4];
			} elseif ($format == 3) {
				return $arr[5] . ', ' . $arr[4];
			} elseif ($format == 4) {
				return $arr[1];
			} elseif ($format == 5) {
				return $arr[3];
			} elseif ($format == 6) {
				return $arr[5] . ', ' . $arr[4] . ', ' . $arr[3] . ', ' . $arr[1];
			} else {
				return $arr;
			}
		} else {
			return false;
		}
	}
	
	/*
	- Currency Conversion (currencyconverterapi)
	- Converts one currency to another
	
	$from     - The 3-letter ISO currency to convert from (ie. USD)
	$to       - The 3-letter ISO currency to convert to (ie. GBP)
	$amount   - The amount of $from to convert to $to (ie. 1000)
	$timeout  - Number of seconds to wait before giving up
	*/
	
	public function convertCurrency($from, $to, $amount, $timeout = 5) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://free.currencyconverterapi.com/api/v3/convert?q=" . $from . "_" . $to . "&compact=y");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		$arr = json_decode($data, true);
		
		return $arr[$from . "_" . $to]["val"] * $amount;
	}
	
	/*
	- Temperature Conversion
	- Converts one temperature to another
	
	$from     - The temperature to convert from.
	            => "c" - celsius 
				=> "f" - fahrenheit
				=> "k" - kelvin
	
	$to       - The temperature to convert to.
				=> "c" - celsius
				=> "f" - fahrenheit
				=> "k" - kelvin
	
	$value    - The temperature to be converted
	*/
	
	public function convertTemperature($from, $to, $value) {
		$from = strtolower($from);
		$to = strtolower($to);
		
		if (is_numeric($value) || is_double($value)) {
			
			// c to f
			if ($from == "c" && $to == "f")
				return ($value * 1.8) + 32;
			
			// c to k
			if ($from == "c" && $to == "k")
				return $value + 273.15;
			
			// f to c
			if ($from == "f" && $to == "c")
				return ($value - 32) / 1.8;
			
			// f to k
			if ($from == "f" && $to == "k")
				return (($value - 32) / 1.8) + 273.15;
			
			// k to c
			if ($from == "k" && $to == "c")
				return $value - 273.15;
			
			// k to f
			if ($from == "k" && $to == "f")
				return (($value - 273.15) * 1.8) + 32;
			
			// default
			return $value;
		}
		
		return false;
	}
	
	/*
	- Get Weather for location (openweathermap)
	- Gets the weather, temperature, pressure, humidity etc for the specified location
	
	$location     - The location to get the weather of ie. "New York City,NY"
	$format       - What to return
	                => 0 - Cloudiness
					=> 1 - Temperature (fahrenheit)
					=> 2 - Air Pressure
					=> 3 - Humidity
					=> 4 - Min Temperature (fahrenheit)
					=> 5 - Max Temperature (fahrenheit)
					=> 6 - Visibility
					=> 7 - Wind Speed
					=> 8 - Wind Direction (degrees)
					=> 9 - Sunrise (unix time)
					=> 10 - Sunset (unix time)
	
	$timeout     - How many seconds to wait for a response before giving up
	*/
	
	public function getWeather($location, $format = 0, $timeout = 5) {
		$ch = curl_init();
		$location = str_replace(" ", "%20", $location);	
		
		curl_setopt($ch, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/weather?q=" . $location);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		$arr = json_decode($data, true);
		if (!isset($arr["message"])) {
			$r_weather = $arr["weather"][0]["description"];
			$r_temp = $arr["main"]["temp"];
			$r_pressure = $arr["main"]["pressure"];
			$r_humidity = $arr["main"]["humidity"];
			$r_temp_min = $arr["main"]["temp_min"];
			$r_temp_max = $arr["main"]["temp_max"];
			$r_visibility = 10000;
			$r_wind_speed = $arr["wind"]["speed"];
			$r_wind_dir = $arr["wind"]["deg"];
			$r_sunrise = $arr["sys"]["sunrise"];
			$r_sunset = $arr["sys"]["sunset"];
			
			$r_temp = $this->convertTemperature("k", "f", $r_temp);
			$r_temp_min = $this->convertTemperature("k", "f", $r_temp_min);
			$r_temp_max = $this->convertTemperature("k", "f", $r_temp_max);

			switch ($format) {
				case 0: return $r_weather; break;
				case 1: return $r_temp; break;
				case 2: return $r_pressure; break;
				case 3: return $r_humidity; break;
				case 4: return $r_temp_min; break;
				case 5: return $r_temp_max; break;
				case 6: return $r_visibility; break;
				case 7: return $r_wind_speed; break;
				case 8: return $r_wind_dir; break;
				case 9: return $r_sunrise; break;
				case 10: return $r_sunset; break;	
			}
			
			// default
			return $arr;
		}
		
		return false;
	}
	
	/*
	- Get Alexa Rank
	- Gets the alexa rank for a website based on the URL
	
	$url     - The url to get the alexa rank for
	*/
	
	public function getAlexaRank($url) {
		$xml = simplexml_load_file("http://data.alexa.com/data?cli=10&url=" . $url);
		if(isset($xml->SD))
			return $xml->SD->REACH->attributes();
	}
	
	
	/*
	- Get currency
	- Returns the currency symbol for any currency.
	
	$iso     - The 3 letter ISO code (ie GBP)
	*/
	
	public function getCurrency($iso) {
		$formatted = "";
		
		switch (strtoupper($iso)) {
			case "ZMW": $formatted = "ZK"; break;
			case "ZAR": $formatted = "R"; break;
			case "YER": $formatted = "﷼"; break;
			case "XPF": $formatted = "Fr"; break;
			case "XOF": $formatted = "Fr"; break;
			case "XCD": $formatted = "$"; break;
			case "XAF": $formatted = "Fr"; break;
			case "WST": $formatted = "T"; break;
			case "VUV": $formatted = "Vt"; break;
			case "VND": $formatted = "₫"; break;
			case "VEF": $formatted = "Bs F"; break;
			case "UZS": $formatted = "лв"; break;
			case "UYU": $formatted = "$"; break;
			case "USD": $formatted = "$"; break;
			case "UGX": $formatted = "Sh"; break;
			case "UAH": $formatted = "₴"; break;
			case "TZS": $formatted = "Sh"; break;
			case "TWD": $formatted = "$"; break;
			case "TTD": $formatted = "$"; break;
			case "TRY": $formatted = "t"; break;
			case "TOP": $formatted = "T$"; break;
			case "TND": $formatted = "د.ت"; break;
			case "TMT": $formatted = "m"; break;
			case "TJS": $formatted = "SM"; break;
			case "THB": $formatted = "฿"; break;
			case "SZL": $formatted = "L"; break;
			case "SYP": $formatted = "£"; break;
			case "STD": $formatted = "Db"; break;
			case "SSP": $formatted = "£"; break;
			case "SRD": $formatted = "$"; break;
			case "SOS": $formatted = "Sh"; break;
			case "SLL": $formatted = "Le"; break;
			case "SHP": $formatted = "£"; break;
			case "SGD": $formatted = "$"; break;
			case "SEK": $formatted = "kr"; break;
			case "SDG": $formatted = "£"; break;
			case "SCR": $formatted = "Rs"; break;
			case "SBD": $formatted = "$"; break;
			case "SAR": $formatted = "ر.س"; break;
			case "RWF": $formatted = "Fr"; break;
			case "RUB": $formatted = "₽"; break;
			case "RSD": $formatted = "дин."; break;
			case "RON": $formatted = "lei"; break;
			case "QAR": $formatted = "ر.ق"; break;
			case "PYG": $formatted = "₲"; break;
			case "PRB": $formatted = "p."; break;
			case "PLN": $formatted = "zł"; break;
			case "PKR": $formatted = "Rs"; break;
			case "PHP": $formatted = "₱"; break;
			case "PGK": $formatted = "K"; break;
			case "PEN": $formatted = "S/."; break;
			case "PAB": $formatted = "B/."; break;
			case "OMR": $formatted = "ر.ع."; break;
			case "NZD": $formatted = "$"; break;
			case "NPR": $formatted = "Rs"; break;
			case "NOK": $formatted = "kr"; break;
			case "NIO": $formatted = "C$"; break;
			case "NGN": $formatted = "₦"; break;
			case "NAD": $formatted = "$"; break;
			case "MZN": $formatted = "MT"; break;
			case "MYR": $formatted = "RM"; break;
			case "MXN": $formatted = "$"; break;
			case "MWK": $formatted = "MK"; break;
			case "MVR": $formatted = ".ރ"; break;
			case "MUR": $formatted = "Rs"; break;
			case "MRO": $formatted = "UM"; break;
			case "MOP": $formatted = "P"; break;
			case "MNT": $formatted = "₮"; break;
			case "MMK": $formatted = "Ks"; break;
			case "MKD": $formatted = "ден"; break;
			case "MGA": $formatted = "Ar"; break;
			case "MDL": $formatted = "L"; break;
			case "MAD": $formatted = "د.م."; break;
			case "LYD": $formatted = "ل.د"; break;
			case "LSL": $formatted = "L"; break;
			case "LRD": $formatted = "$"; break;
			case "LKR": $formatted = "Rs"; break;
			case "LBP": $formatted = "ل.ل"; break;
			case "LAK": $formatted = "₭"; break;
			case "KZT": $formatted = "T"; break;
			case "KYD": $formatted = "$"; break;
			case "KWD": $formatted = "د.ك"; break;
			case "KRW": $formatted = "₩"; break;
			case "KPW": $formatted = "₩"; break;
			case "KMF": $formatted = "Fr"; break;
			case "KHR": $formatted = "៛"; break;
			case "KGS": $formatted = "лв"; break;
			case "KES": $formatted = "Sh"; break;
			case "JPY": $formatted = "¥"; break;
			case "JOD": $formatted = "د.ا"; break;
			case "JMD": $formatted = "$"; break;
			case "JEP": $formatted = "£"; break;
			case "ISK": $formatted = "kr"; break;
			case "IRR": $formatted = "﷼"; break;
			case "IQD": $formatted = "ع.د"; break;
			case "INR": $formatted = "₹"; break;
			case "IMP": $formatted = "£"; break;
			case "ILS": $formatted = "₪"; break;
			case "IDR": $formatted = "Rp"; break;
			case "HUF": $formatted = "Ft"; break;
			case "HTG": $formatted = "G"; break;
			case "HRK": $formatted = "kn"; break;
			case "HNL": $formatted = "L"; break;
			case "HKD": $formatted = "$"; break;
			case "GYD": $formatted = "$"; break;
			case "GTQ": $formatted = "Q"; break;
			case "GNF": $formatted = "Fr"; break;
			case "GMD": $formatted = "D"; break;
			case "GIP": $formatted = "$"; break;
			case "GHS": $formatted = "₵"; break;
			case "GGP": $formatted = "£"; break;
			case "GEL": $formatted = "ლ"; break;
			case "GBP": $formatted = "£"; break;
			case "FKP": $formatted = "£"; break;
			case "FJD": $formatted = "$"; break;
			case "EUR": $formatted = "€"; break;
			case "ETB": $formatted = "Br"; break;
			case "ERN": $formatted = "Nfk"; break;
			case "EGP": $formatted = "£"; break;
			case "DZD": $formatted = "د.ج"; break;
			case "DOP": $formatted = "$"; break;
			case "DKK": $formatted = "kr"; break;
			case "DJF": $formatted = "Fr"; break;
			case "CZK": $formatted = "Kč"; break;
			case "CVE": $formatted = "$"; break;
			case "CUP": $formatted = "$"; break;
			case "CUC": $formatted = "$"; break;
			case "CRC": $formatted = "₡"; break;
			case "COP": $formatted = "$"; break;
			case "CNY": $formatted = "¥"; break;
			case "CLP": $formatted = "$"; break;
			case "CHF": $formatted = "Fr"; break;
			case "CDF": $formatted = "Fr"; break;
			case "CAD": $formatted = "$"; break;
			case "BZD": $formatted = "$"; break;
			case "BYR": $formatted = "Br"; break;
			case "BWP": $formatted = "P"; break;
			case "BTN": $formatted = "Nu."; break;
			case "BSD": $formatted = "$"; break;
			case "BRL": $formatted = "R$"; break;
			case "BOB": $formatted = "Bs."; break;
			case "BND": $formatted = "$"; break;
			case "BIF": $formatted = "Fr"; break;
			case "BHD": $formatted = ".د.ب"; break;
			case "BGN": $formatted = "лв"; break;
			case "BDT": $formatted = "৳"; break;
			case "BBD": $formatted = "$"; break;
			case "BAM": $formatted = "KM"; break;
			case "AWG": $formatted = "ƒ"; break;
			case "AUD": $formatted = "$"; break;
			case "ARS": $formatted = "$"; break;
			case "AOA": $formatted = "Kz"; break;
			case "ANG": $formatted = "ƒ"; break;
			case "ALL": $formatted = "L"; break;
			case "AFN": $formatted = "؋"; break;
			case "AED": $formatted = "د.إ"; break;
				
			default: $formatted = ""; break;
		}
		
		return $formatted;
	}
	
	/*
	- Format Price
	- Formats price into standard price format (eg. $1,293.26 USD)
	
	$price        - The number to be formatted.
	$currency     - The three letter currency code.
	$currencyCode - Whether or not to display the currency code at the end.
	$change       - Whether or not to display the two digit change (cents) 
	                at the end of the price.
	*/
	
	public function formatPrice($price, $currency = "USD", $currencyCode = true, $change = true) {
		if ($price > 1000) {
			if ($change)
				$price = $this->formatNumber($price, 2);
			else
				$price = $this->formatNumber($price);
		}
		
		$formatted = "";
		
		switch (strtoupper($currency)) {
			case "ZMW": $formatted = "ZK"; break;
			case "ZAR": $formatted = "R"; break;
			case "YER": $formatted = "﷼"; break;
			case "XPF": $formatted = "Fr"; break;
			case "XOF": $formatted = "Fr"; break;
			case "XCD": $formatted = "$"; break;
			case "XAF": $formatted = "Fr"; break;
			case "WST": $formatted = "T"; break;
			case "VUV": $formatted = "Vt"; break;
			case "VND": $formatted = "₫"; break;
			case "VEF": $formatted = "Bs F"; break;
			case "UZS": $formatted = "лв"; break;
			case "UYU": $formatted = "$"; break;
			case "USD": $formatted = "$"; break;
			case "UGX": $formatted = "Sh"; break;
			case "UAH": $formatted = "₴"; break;
			case "TZS": $formatted = "Sh"; break;
			case "TWD": $formatted = "$"; break;
			case "TTD": $formatted = "$"; break;
			case "TRY": $formatted = "t"; break;
			case "TOP": $formatted = "T$"; break;
			case "TND": $formatted = "د.ت"; break;
			case "TMT": $formatted = "m"; break;
			case "TJS": $formatted = "SM"; break;
			case "THB": $formatted = "฿"; break;
			case "SZL": $formatted = "L"; break;
			case "SYP": $formatted = "£"; break;
			case "STD": $formatted = "Db"; break;
			case "SSP": $formatted = "£"; break;
			case "SRD": $formatted = "$"; break;
			case "SOS": $formatted = "Sh"; break;
			case "SLL": $formatted = "Le"; break;
			case "SHP": $formatted = "£"; break;
			case "SGD": $formatted = "$"; break;
			case "SEK": $formatted = "kr"; break;
			case "SDG": $formatted = "£"; break;
			case "SCR": $formatted = "Rs"; break;
			case "SBD": $formatted = "$"; break;
			case "SAR": $formatted = "ر.س"; break;
			case "RWF": $formatted = "Fr"; break;
			case "RUB": $formatted = "₽"; break;
			case "RSD": $formatted = "дин."; break;
			case "RON": $formatted = "lei"; break;
			case "QAR": $formatted = "ر.ق"; break;
			case "PYG": $formatted = "₲"; break;
			case "PRB": $formatted = "p."; break;
			case "PLN": $formatted = "zł"; break;
			case "PKR": $formatted = "Rs"; break;
			case "PHP": $formatted = "₱"; break;
			case "PGK": $formatted = "K"; break;
			case "PEN": $formatted = "S/."; break;
			case "PAB": $formatted = "B/."; break;
			case "OMR": $formatted = "ر.ع."; break;
			case "NZD": $formatted = "$"; break;
			case "NPR": $formatted = "Rs"; break;
			case "NOK": $formatted = "kr"; break;
			case "NIO": $formatted = "C$"; break;
			case "NGN": $formatted = "₦"; break;
			case "NAD": $formatted = "$"; break;
			case "MZN": $formatted = "MT"; break;
			case "MYR": $formatted = "RM"; break;
			case "MXN": $formatted = "$"; break;
			case "MWK": $formatted = "MK"; break;
			case "MVR": $formatted = ".ރ"; break;
			case "MUR": $formatted = "Rs"; break;
			case "MRO": $formatted = "UM"; break;
			case "MOP": $formatted = "P"; break;
			case "MNT": $formatted = "₮"; break;
			case "MMK": $formatted = "Ks"; break;
			case "MKD": $formatted = "ден"; break;
			case "MGA": $formatted = "Ar"; break;
			case "MDL": $formatted = "L"; break;
			case "MAD": $formatted = "د.م."; break;
			case "LYD": $formatted = "ل.د"; break;
			case "LSL": $formatted = "L"; break;
			case "LRD": $formatted = "$"; break;
			case "LKR": $formatted = "Rs"; break;
			case "LBP": $formatted = "ل.ل"; break;
			case "LAK": $formatted = "₭"; break;
			case "KZT": $formatted = "T"; break;
			case "KYD": $formatted = "$"; break;
			case "KWD": $formatted = "د.ك"; break;
			case "KRW": $formatted = "₩"; break;
			case "KPW": $formatted = "₩"; break;
			case "KMF": $formatted = "Fr"; break;
			case "KHR": $formatted = "៛"; break;
			case "KGS": $formatted = "лв"; break;
			case "KES": $formatted = "Sh"; break;
			case "JPY": $formatted = "¥"; break;
			case "JOD": $formatted = "د.ا"; break;
			case "JMD": $formatted = "$"; break;
			case "JEP": $formatted = "£"; break;
			case "ISK": $formatted = "kr"; break;
			case "IRR": $formatted = "﷼"; break;
			case "IQD": $formatted = "ع.د"; break;
			case "INR": $formatted = "₹"; break;
			case "IMP": $formatted = "£"; break;
			case "ILS": $formatted = "₪"; break;
			case "IDR": $formatted = "Rp"; break;
			case "HUF": $formatted = "Ft"; break;
			case "HTG": $formatted = "G"; break;
			case "HRK": $formatted = "kn"; break;
			case "HNL": $formatted = "L"; break;
			case "HKD": $formatted = "$"; break;
			case "GYD": $formatted = "$"; break;
			case "GTQ": $formatted = "Q"; break;
			case "GNF": $formatted = "Fr"; break;
			case "GMD": $formatted = "D"; break;
			case "GIP": $formatted = "$"; break;
			case "GHS": $formatted = "₵"; break;
			case "GGP": $formatted = "£"; break;
			case "GEL": $formatted = "ლ"; break;
			case "GBP": $formatted = "£"; break;
			case "FKP": $formatted = "£"; break;
			case "FJD": $formatted = "$"; break;
			case "EUR": $formatted = "€"; break;
			case "ETB": $formatted = "Br"; break;
			case "ERN": $formatted = "Nfk"; break;
			case "EGP": $formatted = "£"; break;
			case "DZD": $formatted = "د.ج"; break;
			case "DOP": $formatted = "$"; break;
			case "DKK": $formatted = "kr"; break;
			case "DJF": $formatted = "Fr"; break;
			case "CZK": $formatted = "Kč"; break;
			case "CVE": $formatted = "$"; break;
			case "CUP": $formatted = "$"; break;
			case "CUC": $formatted = "$"; break;
			case "CRC": $formatted = "₡"; break;
			case "COP": $formatted = "$"; break;
			case "CNY": $formatted = "¥"; break;
			case "CLP": $formatted = "$"; break;
			case "CHF": $formatted = "Fr"; break;
			case "CDF": $formatted = "Fr"; break;
			case "CAD": $formatted = "$"; break;
			case "BZD": $formatted = "$"; break;
			case "BYR": $formatted = "Br"; break;
			case "BWP": $formatted = "P"; break;
			case "BTN": $formatted = "Nu."; break;
			case "BSD": $formatted = "$"; break;
			case "BRL": $formatted = "R$"; break;
			case "BOB": $formatted = "Bs."; break;
			case "BND": $formatted = "$"; break;
			case "BIF": $formatted = "Fr"; break;
			case "BHD": $formatted = ".د.ب"; break;
			case "BGN": $formatted = "лв"; break;
			case "BDT": $formatted = "৳"; break;
			case "BBD": $formatted = "$"; break;
			case "BAM": $formatted = "KM"; break;
			case "AWG": $formatted = "ƒ"; break;
			case "AUD": $formatted = "$"; break;
			case "ARS": $formatted = "$"; break;
			case "AOA": $formatted = "Kz"; break;
			case "ANG": $formatted = "ƒ"; break;
			case "ALL": $formatted = "L"; break;
			case "AFN": $formatted = "؋"; break;
			case "AED": $formatted = "د.إ"; break;
				
			default: $formatted = ""; break;
		}
		
		if ($change && strpos($price, '.') === false) {
			$price .= '.00';
		} elseif ($change && strpos($price, '.') !== false) {
			$chg = explode(".", $price);
			
			if (strlen($chg[1]) < 2)
				$price .= '0';
			else {
				$nchg = substr($chg[1], 0, 2);
				$price = $chg[0] . "." . $nchg;
			}
		}
		
		$formatted .= strval($price);
		
		if ($currencyCode)
			$formatted .= " " . strtoupper($currency);
		
		return $formatted;
	}
	
	/*
	- Get File Extension
	- Gets the file extension from the file's name.
	
	$fileName      - The name of the file to get the extension of.
	$includePeriod - Whether or not to include the prefix period (eg. ".txt")
	*/
	
	public function getFileExtension($fileName, $includePeriod = true) {
		if (strpos($fileName, ".")) {
			$sides = explode(".", $fileName);
			$ext = "";

			if ($includePeriod)
				$ext .= ".";

			$ext .= $sides[count($sides) - 1];
			return $ext;
		} else
			return "N/A";
	}
	
	/*
	- Get Gravatar URL
	- Get the URL for a gravatar attached to someone's email address to be used
	  in the <img> tag.
	  
	$email     - The email to fetch the gravatar of.
	$size      - The size of the gravatar to be fetched (default 40 pixels)
	*/
	
	public function getGravatarURL($email, $size = 40) {
		$email = md5(trim($email));
		$grav_url = "http://www.gravatar.com/avatar/" . $email . "?s=" . $size;
		return $grav_url;
	}
	
	/*
	- File Upload
	- Allows the upload of a file with specified (or no) limitations.
	- Returns 0 on success
	- Returns 1 if overwrite is disabled and file already exists
	- Returns 2 if it does not meet any valid extensions
	- Returns 3 if a max file size is set and this file exceeds it
	- Returns 4 if width is smaller than min width or height is smaller than min height
	- Returns 5 if width is larger than max width or height is larger than max height
	- Returns 6 if an unexpected error occurred and the file couldn't be uploaded
	
	$file            - $_FILES['filename']; from a form with input type="file" and name="filename"
	$newLocation     - The directory relative to the location of this script to move the file to,
	                   directory will be created if it does not exist already.
	$newName         - The new name of the file without the extension (eg. "image")
	$validExtensions - Array containing a list of valid extensions, file will be blocked if it does
	                   not have any one of these extensions (set it to null for no limits on extensions)
	$overwrite       - Overwrite the file if it already exists in this place and as this name?
	$isImage         - If only images can be uploaded, set this to true.
	$minImgWidth     - The minimum width the image can be. Set to 0 for no minimum width.
	$minImgHeight    - The minimuim height the image can be. Set to 0 for no minimum height.
	$maxImgWidth     - The maximum width the image can be. Set to 0 for no maximum width.
	$maxImgHeight    - The maximum height the image can be. Set to 0 for no maximum height.
	$maxSize         - Max size the file can be in bytes, set to 0 for unlimited.
	*/
	public function upload($file, $newLocation, $newName, $validExtensions = null, $overwrite = true, $isImage = false, $minImgWidth = 0, $minImgHeight = 0, $maxImgWidth = 0, $maxImgHeight = 0, $maxSize = 8388608) {
		
		$fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
		$targFile = $newLocation . $newName . "." . $fileType;
		
		$failed = false;
		
		if (!$overwrite && file_exists($targFile)) {
			return 1;
			$failed = true;
		}
		
		if (!$failed) {
			if ($validExtensions != null) {
				$validExt = false;
				foreach ($validExtensions as $validExtension) {
					if ($fileType == $validExtension)
						$validExt = true;
				}
				if (!$validExt) {
					return 2;
					$failed = true;
				}
			}
			
			if (!$failed) {
				if ($maxSize > 0) {
					if ($file['size'] > $maxSize) {
						return 3;
						$failed = true;
					}
				}
				
				if (!$failed) {
					if ($isImage) {
						list($width, $height) = getimagesize($file['tmp_name']);

						if ($minImgWidth > 0) {
							if ($width < $minImgWidth) {
								return 4;
								$failed = true;
							}
						}

						if ($minImgHeight > 0) {
							if (!$failed) {
								if ($height < $minImgHeight) {
									return 4;
									$failed = true;
								}
							}
						}

						if ($maxImgWidth > 0) {
							if (!$failed) {
								if ($width > $maxImgWidth) {
									return 5;
									$failed = true;
								}
							}
						}

						if ($maxImgHeight > 0) {
							if (!$failed) {
								if ($height > $maxImgHeight) {
									return 5;
									$failed = true;
								}
							}
						}
					}
					
					if (!$failed) {
						if (!file_exists($newLocation))
							mkdir($newLocation);
						
						if (move_uploaded_file($file['tmp_name'], $targFile))
							return 0;
						else
							return 6;
					}
				}
			}
		}
				
		return 0;
	}
	
	/*
	- Copy From URL
	- Clones a file from the URL provided and places the copy in your server.
	
	- ! Requires cURL ! -
	
	$url         - The full URL path to the file to copy
	$newLocation - The directory location relative to the location of this script to
	               place the cloned file.
	$newName     - Optional, the name (and the extension!) the cloned file should be
	               renamed to. If left blank the name will stay the same.
	*/
	
	public function copyFromUrl($url, $newLocation, $newName = '', $timeOutSecs = 300) {
		$curl = curl_init($url);
		
		if ($newName == '') {
			$oldName = explode("/", $url);
			$newName = $oldName[count($oldName) - 1];
		}
		
		if (substr($newLocation, -1) != '/')
			$newLocation .= '/';
		
		$file = fopen($newLocation . $newName, 'wb');
		curl_setopt($curl, CURLOPT_FILE, $file);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeOutSecs);
		$resp = curl_exec($curl);
		
		if (curl_errno($curl))
			echo "cURL Error: " . curl_error($curl);
		elseif ($resp !== false) {
			curl_close($curl);
			fclose($file);
			return true;
		}
		
		return false;
	}
	
	public function extractZip($zipName, $newLocation) {
		$zip = new ZipArchive;
	
		if ($zip->open($zipName) === TRUE) {
			if (substr($newLocation, -1) != '/')
				$newLocation .= '/';
			
			if (!file_exists($newLocation))
				mkdir($newLocation);
			
			return $zip->extractTo($newLocation);
			$zip->close();
		}
		
		return false;
	}
}; 