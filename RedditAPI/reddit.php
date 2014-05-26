<?php

class reddit {
    public $modhash = "";

    private function makeCall($method, $end_point, $params = false){
        $reddit_api_url = "http://reddit.com/";
        $api_type = "json";

        $curl = curl_init($reddit_api_url);

        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //Set user agent
        curl_setopt($curl, CURLOPT_USERAGENT, "PHP Reddit Client 0.02 by masterkoppa");


        if($params == false){
            $params = array();
        }

        $params["api_type"] = $api_type;

        switch($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, True); //Set the curl request to do a post
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Length:0"));// Set the header
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, True); //Set the curl request to do a put
                break;
        }

        //Set the url to call
        $url = sprintf("%s%s?%s", $reddit_api_url, $end_point, http_build_query($params));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($curl);
        //echo "URL:\n";
        //echo $url;
        //echo "\n";
        //echo $result;

        if(!curl_errno($curl)){
            $info = curl_getinfo($curl);
            $status_code = $info["http_code"];
            $n = 0;

            //While I keep getting redirects and Im less than 10 redirects
            while($status_code == 302 && $n < 10){
                //echo "Got a redirect\n";
                $output_array = array();
                preg_match("/https?\:\/\/[^\" ]+/i", $result, $output_array);
                //echo $result;
                //echo $output_array;
                $location = $output_array[0];

                //echo "New location\n";
                //echo $location;

                curl_setopt($curl, CURLOPT_URL, $location); //Set the URL again
                $result = curl_exec($curl); //Try the request again
                $info = curl_getinfo($curl); //Extract info
                $status_code = $info["http_code"]; //Check the code

                $n += 1;
            }
            // Print info
            //echo "\nResult:\n";
            //echo $result."\n";
            //echo 'Took ' . $info['total_time'] . ' seconds\n';
        }

        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        //echo "Content Type: ".$contentType.'\n';
        curl_close($curl);

        list($headers, $content) = explode("\r\n\r\n", $result, 2);

        if (strpos($contentType, 'json') !== FALSE){
            return $content;
        }else{
            return $content;
        }
    }

    public function login($user, $password){
        $login_path = "api/login/";

        $login_params = array("user" => $user, "passwd" => $password, "rem" => "False");

        $json = $this->makeCall("POST", $login_path, $login_params);
        $modhash = $json["json"]["data"]["modhash"];

        $this->modhash = $modhash;
    }

    public function subredditArticles($subreddit, $sorting){
        $params = array();

        //$params["show"] = "all";
        $params["limit"] = 25;
        $params["count"] = 10;

        $end_point = sprintf("%s/hot.json", $subreddit);

        return $this->makeCall("GET", $end_point, $params);
    }
}

$reddit = new reddit;
?>
