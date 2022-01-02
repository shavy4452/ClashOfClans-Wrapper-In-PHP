<?php

{
    class ClashAPILogin {

        /**
         * @param string $dev_email
         * @param string $dev_password
         * @return string
         * Function to create an key using email and password
         */
        function login($dev_email,$dev_password){
           $url = "https://developer.clashofclans.com/api/login";
           $data = '{"email":"'.$dev_email.'","password":"'.$dev_password.'"}';
           $curl = curl_init($url);
           curl_setopt($curl, CURLOPT_URL, $url);
           curl_setopt($curl, CURLOPT_POST, true);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           $headers = array(
               "Content-Type: application/json",
               "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
            );
            $cookieFile = "./API/temp/cookie.txt";
            if(file_exists($cookieFile)) {
                unlink($cookieFile);
            }
            $fh = fopen($cookieFile, "w+");
            fwrite($fh, "");
            fclose($fh);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile); 
            $resp = curl_exec($curl);
            $statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
            if($statusCode == 403){
                throw "Error with credentials, check developer email and password";    //403 Forbidden
            }
            curl_close($curl);
    
            //ip address extraction
            $ip = 'https://api.ipify.org';
            $ipReq = curl_init($ip);
            curl_setopt($ipReq, CURLOPT_URL, $ip);
            curl_setopt($ipReq, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ipReq, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ipReq, CURLOPT_SSL_VERIFYPEER, false);
            $getIP = curl_exec($ipReq);
            curl_close($ipReq);

            // check how many keys exists and create a new one
            $cookieFile = "./API/temp/cookie.txt";
            $ch_2 = "https://developer.clashofclans.com/api/apikey/list";
            $ch = curl_init($ch_2);
            curl_setopt($ch, CURLOPT_URL, $ch_2);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            $result = curl_exec($ch);
            curl_close($ch); 
            $result= json_decode($result);
            
            $keys = $result->keys;
            if(count($keys) == 10){
                $revoke_url = "https://developer.clashofclans.com/api/apikey/revoke";
                foreach($keys as $key){
                    $key_id = $key->id;
                    $key_data = '{"id": "'.$key_id.'"}';
                    $headers = array(
                        "Content-Type: application/json",
                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
                     );
                    $ch = curl_init($revoke_url);
                    curl_setopt($ch, CURLOPT_URL, $revoke_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $key_data);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
                    $result = curl_exec($ch);
                    curl_close($ch); 
                }
                $create_key_url = "https://developer.clashofclans.com/api/apikey/create";        
                $key_data = '{"name": "COC.PHP","description": "Key created using coc.php","cidrRanges": ["'.$getIP.'"],"scopes": null}';
                $ch = curl_init($create_key_url);
                curl_setopt($ch, CURLOPT_URL, $create_key_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $key_data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
                curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
                $result = curl_exec($ch);
                curl_close($ch); 
                $key_res= json_decode($result);
                $created_key = $key_res->key->key;
                $cred_temp_file = "./API/temp/creds.php";
                if(file_exists($cred_temp_file)) {
                    unlink($cred_temp_file);
                }
                $fh = fopen($cred_temp_file, "w+");
                fwrite($fh, "<?php\n");
                fwrite($fh, '$dev_token = "'.$created_key.'";');
                fwrite($fh, "\n?>");
                fclose($fh);


            }
            else{
                        $create_key_url = "https://developer.clashofclans.com/api/apikey/create";        
                        $key_data = '{"name": "COC.PHP","description": "Key created using coc.php","cidrRanges": ["'.$getIP.'"],"scopes": null}';
                        $ch = curl_init($create_key_url);
                        curl_setopt($ch, CURLOPT_URL, $create_key_url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = array(
                            "Content-Type: application/json",
                            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
                         );
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $key_data);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
                        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
                        $result = curl_exec($ch);
                        curl_close($ch); 
                        $key_res= json_decode($result);
                        $created_key = $key_res->key->key;
                        $cred_temp_file = "./API/temp/creds.php";
                        if(file_exists($cred_temp_file)) {
                            unlink($cred_temp_file);
                        }
                        $fh = fopen($cred_temp_file, "w+");
                        fwrite($fh, "<?php\n");
                        fwrite($fh, '$dev_token = "'.$created_key.'";');
                        fwrite($fh, "\n?>");
                        fclose($fh);
                        
        
                    
                }
                return $created_key;
       }
    }

    }


?>
