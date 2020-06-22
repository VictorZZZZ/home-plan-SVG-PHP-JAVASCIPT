<?php
require __DIR__ . '/vendor/autoload.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('client_secret.json');
    $client->setAccessType('offline');


// Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);

//        echo "Время с последнего обновления ключа ".(time()-$accessToken['created'])."</br>".". Следующее обновление через ".(3600-(time()-$accessToken['created']))."</br></br>";

        if(time()-$accessToken['created'] > $accessToken['expires_in']){
            //Если ключ закончился - обновляем его.
            // save refresh token to some variable
            $client->setAccessToken($accessToken);


            $refreshTokenSaved = $client->getRefreshToken();

            // update access token
            $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);


            // pass access token to some variable
            $accessTokenUpdated = $client->getAccessToken();


            // append refresh token
            $accessTokenUpdated['refresh_token'] = $refreshTokenSaved;
            file_put_contents($credentialsPath, json_encode($accessTokenUpdated));

            $client->setAccessToken($accessTokenUpdated);
            return $client;
        } else {
            $client->setAccessToken($accessToken);
            return $client;
        }
    } else {

// Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';

        $authCode = '4/sgFZ8nr6OxMjpCbc5cL1JIaTGT45vuWcprmIGNk8NU_CPuV2uIrR-fc';//trim(fgets(STDIN));

// Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

// Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }


        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);

    }

    return $client;


}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}


function getFloorInfo($floor_range,$service,$spreadsheetId){

    $response = $service->spreadsheets_values->get($spreadsheetId, $floor_range);
    $values = $response->getValues();

    if (!empty($values)) {
        foreach($values as $key=>$val){
            if($val[2]=='Свободно') $values[$key][3]='green';
            else $values[$key][3]='red';
        }
        return $values;
    } else {
        return false;
    }

}


?>


