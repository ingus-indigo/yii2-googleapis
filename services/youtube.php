<?php
/**
 * @link https://github.com/ingus-indigo/yii2-omni-googleapis
 * @copyright Copyright (c) 2015 ingus-inigo
 * @license MIT License (http://opensource.org/licenses/MIT)
 */
namespace omni\googleApis\services;

/**
 * Facebook allows authentication via Facebook OAuth.
 *
 * In order to use Facebook OAuth you must register your application at <https://developers.facebook.com/apps>.
 *
 * Example application configuration:
 *
 * ~~~
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'facebook' => [
 *                 'class' => 'yii\authclient\clients\Facebook',
 *                 'clientId' => 'facebook_client_id',
 *                 'clientSecret' => 'facebook_client_secret',
 *             ],
 *         ],
 *     ]
 *     ...
 * ]
 * ~~~
 *
 * @see https://developers.facebook.com/apps
 * @see http://developers.facebook.com/docs/reference/api
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
use yii\base\component;

class Youtube extends component
{
    public $id;
    public $localFilePath;

    public function hello(){
        echo $this->id;
    }
}
