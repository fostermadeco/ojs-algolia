<?php

require_once dirname(dirname(__FILE__)) . '/lib/vendor/autoload.php';

use AlgoliaSearch\Client;
use AlgoliaSearch\AlgoliaException;

class AlgoliaEngine {

    protected $settings = null;
    protected $client = null;
    protected $index = null;

    /**
     * AlgoliaEngine constructor.
     *
     * @param $settings
     * @param $search_only
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->index = $settings['index'];

        try {
            $this->client = new Client($this->settings['app_id'], $this->settings['api_key']);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return Client|null
     */
    public function get_client()
    {
        return $this->client;
    }

    /**
     * Retrieves all the indexes available
     *
     * @return array|string
     */
    public function get_indexes()
    {
        try {
            $indexes = $this->client->listIndexes();

            $data = array();
            foreach ($indexes['items'] as $index) {
                $data[] = $index['name'];
            }

            return $data;
        } catch (AlgoliaException $e) {
            return false;
        }
    }

    /**
     * Adds/Updates objects in the index
     *
     * @param $index_name
     * @param $objects
     * @return bool|string
     */
    public function index($objects)
    {
        $index = $this->client->initIndex($this->index);

        try {
            $success = $index->batchObjects($objects);
        } catch (AlgoliaException $e) {
            return $e->getMessage();
        }

        return $success;
    }

    /**
     * Deletes an object from the index
     *
     * @param $index_name
     * @param $objects
     * @return bool
     */
    public function delete($objects)
    {
        $index = $this->client->initIndex($this->index);

        try {
            $index->batchObjects($objects);
        } catch (AlgoliaException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Deletes all objects in the specified index
     *
     * @param $index_name
     * @return string
     */
    public function clear_index()
    {
        $index = $this->client->initIndex($this->index);

        try {
            $index->clearIndex();
        } catch (AlgoliaException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Sets the index prefix based on environment
     *
     * @return string
     */
    protected function setIndexEnv()
    {
        return defined('ENV') ? ENV . '_' : '';
    }
}