<?php
/**
 * @link https://github.com/ingus-indigo/yii2-omni-googleapis
 * @copyright Copyright (c) 2015 ingus-inigo
 * @license MIT License (http://opensource.org/licenses/MIT)
 */

namespace omni\googleApis;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;

/**
 * Collection is a storage for all google api service in the application.
 *
 * Example application configuration:
 *
 * ~~~
 * 'components' => [
 *     'ServiceCollection' => [
 *         'class' => 'omni\googleApis\Collection',
 *         'services' => [
 *             'youtube' => [
 *                  'class' => 'omni\googleApis\services\youtube'
 *                  'localFileUpload' => '{location of local file path.}
 *             ],
 *              'map' => [
 *                  ....
 *             ],
 *         ],
 *         ],
 *     ]
 *     ...
 * ]
 * ~~~
 *
 * @property $_services services List of google api services. This property is read-only.
 *
 */
class Collection extends Component
{
    /**
     * @var array list of google api service with their configuration in format: 'services' => [...]
     */
    private $_services = [];


    /**
     * @param array $services list of google api service
     */
    public function setServices(array $services)
    {
        $this->_services = $services;
    }

    /**
     * @return ServiceInterface[] list of google service.
     */
    public function getServices()
    {
        $services = [];
        foreach ($this->_services as $id => $service) {
            $services[$id] = $this->getService($id);
        }

        return $services;
    }

    /**
     * @param string $id service id.
     * @return ServiceInterface google service instance.
     * @throws InvalidParamException on non existing google service request.
     */
    public function getService($id)
    {
        if (!array_key_exists($id, $this->_services)) {
            throw new InvalidParamException("Unknown google service api '{$id}'.");
        }
        if (!is_object($this->_services[$id])) {
            $this->_services[$id] = $this->createService($id, $this->_services[$id]);
        }

        return $this->_services[$id];
    }

    /**
     * Checks if google service exists in the hub.
     * @param string $id service id.
     * @return boolean whether service exist.
     */
    public function hasService($id)
    {
        return array_key_exists($id, $this->_services);
    }

    /**
     * Creates google api service instance from its array configuration.
     * @param string $id google service id.
     * @param array $config google service instance configuration.
     * @return ServiceInterface google service instance.
     */
    protected function createService($id, $config)
    {
        $config['id'] = $id;

        return Yii::createObject($config);
    }
}
