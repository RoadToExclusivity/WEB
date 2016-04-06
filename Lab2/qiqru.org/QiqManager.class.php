<?php

class QiqManager
{
     const SLEEP = 1;
     const COOKIE_FILE   =   "cookie.txt";
     const AUTH_URL      =   "http://qiqru.org/index.php?action=login";
	 const COMMENTS_URL  =   "http://qiqru.org/a2/addcom.php?";
	 const MAIN_URL		 =   "http://qiqru.org/";
	 const FAILED_DOWNLOAD_SLEEP = 2;
	 const ATTEMPTS = 5;

    public function __construct($login, $pass)
    {
        $this->login( self::AUTH_URL, $login, $pass );
    }
	
	private function initCurl($url, $ref, $postfields)
	{
		$ch = curl_init();

        if( strtolower((substr($url, 0, 5)) == 'https') )
        {
            // если соединяемся с https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $ref);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent=Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_COOKIEFILE, self::COOKIE_FILE);
        curl_setopt($ch, CURLOPT_COOKIEJAR, self::COOKIE_FILE);

        $result=curl_exec($ch);
        curl_close($ch);

        return $result;
	}
	
	private function login($url, $login, $password)
	{
		return $this->initCurl($url, $url, "login=".$login."&pass=".$password."&mem=0");
	}
	
	private function loadMainPage()
	{
		sleep(self::SLEEP);

        $data = file_get_contents(self::MAIN_URL);

        if (!$data)
        {
            echo "Error load page " . MAIN_URL . ". New attempt.\r\n";

            for ($i = 0; $i < self::ATTEMPTS; $i++)
            {
                sleep(self::FAILED_DOWNLOAD_SLEEP);
                $data = file_get_contents(self::MAIN_URL);
                if ($data)
                {
                    return $data;
                }
            }
        }
		
        return $data;
	}
	
	public function getFirstNewsPage()
	{
		$page = $this->loadMainPage();
		if ($page)
		{
			$html = new DOMDocument();
			$html->preserveWhiteSpace = false;
			if ($html->loadHTML($page))
			{
				$xPathExt = "//*[@id='content']/table[1]//tr[2]/td[3]/h1/a";
				$xPath = new DOMXPath($html);
				$nodelist = $xPath->query($xPathExt);
				
				foreach($nodelist as $n)
				{
					return self::MAIN_URL . $n->getAttribute('href');
				}
			}
		}
		
		return "";
	}
	
	public function sendMessage($url, $text)
	{
		//*[@id="comments_form"]/input[1]
		$urlPieces = explode("/", $url);
		$commentId = $urlPieces[8];		
		return $this->initCurl(self::COMMENTS_URL, self::MAIN_URL, "comment[pid]=" . $commentId . "&comment[type]=2&comment[text]=" . $text);
	}
}
