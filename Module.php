<?php
namespace omni\googleApis;

use Yii;
class Module extends \yii\base\module
{
    public $controllerNamespace = 'omni\googleApis\controllers';
    public $defaultRoute = 'default';

    /*
     * You can acquire an OAuth 2.0 client ID and client secret from the
     * Google Developers Console <https://console.developers.google.com/>
     * For more information about using OAuth 2.0 to access Google APIs, please see:
     * <https://developers.google.com/youtube/v3/guides/authentication>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    public $OAUTH2_CLIENT_ID = "";
    public $OAUTH2_CLIENT_SECRET = "";


    public $client = '';
    public $redirect = '';

    public $SCOPE = [
        'youtube' => 'https://www.googleapis.com/auth/youtube'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->client = new \Google_Client;
        $this->client->setClientId($this->OAUTH2_CLIENT_ID);
        $this->client->setClientSecret($this->OAUTH2_CLIENT_SECRET);

        $this->redirect ='http://ucms.siamphone2.dev/googleapis/default/callback';

        $this->client->setRedirectUri($this->redirect);
    }

    public function checkAccessToken($scope)
    {
        if (isset($_GET['code'])) {
            echo Yii::$app->session['state']."==".$_GET['state'];

            if (strval(Yii::$app->session['state']) !== strval($_GET['state'])) {
                die('The session state did not match.');
            }

            $this->client->authenticate($_GET['code']);
            Yii::$app->session['token'] = $this->client->getAccessToken();
            header('Location: ' . $this->redirect);
        }

        if (isset(Yii::$app->session['token'])) {
            $this->client->setAccessToken(Yii::$app->session['token']);
        }

        // Check to ensure that the access token was successfully acquired.
        if (!$this->client->getAccessToken()) {
            // If the user hasn't authorized the app, initiate the OAuth flow
            $state = mt_rand();
            $this->client->setState($state);
            Yii::$app->session['state'] = $state;

            $this->client->setScopes($scope);
            $authUrl = $this->client->createAuthUrl();
            $output = '<h3>Authorization Required</h3><p>You need to <a href="'.$authUrl.'">authorize access</a> before proceeding.<p>';
            echo $output;
            exit;
        }else{
            return $this->client->getAccessToken();
        }
    }

    public function getYoutubeAPI()
    {
        if($this->checkAccessToken($this->SCOPE['youtube'])) {
            return new \Google_Service_YouTube($this->client);
        }
    }
}