<?php


/**
 * Class For Connecting Meeteo API
 * @since   1.0
 * @author  bkesh
 * @modified
 */
if (!class_exists('Meeteo_Api')) {

    class Meeteo_Api
    {
        /**
         * Meeteo App ID
         * @var
         */
        public $meeteo_app_id;

        /**
         * Here goes instance
         * @var
         */
        protected static $_instance;

        /**
         *  Meeteo API endpoint
         * @var string
         */

       private $api_url = 'https://api.meeteo.io/thirdParty/v1/';  //# prod url
    //    private $api_url = 'https://api-test.meeteo.io/thirdParty/v1/';  //# test url
    //    private $api_url = 'http://fidato.test/thirdParty/v1/';  //# local url

        public static function instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct($meeteo_app_id = '')
        {
            $this->meeteo_app_id = $meeteo_app_id;
        }

        /**
         * Send request to API
         * @param $method
         * @param $data
         * @param string $request
         * @return array|bool|string|WP_Error
         */
        protected function sendRequest($method, $data, $request = "GET")
        {
            $request_url = $this->api_url . $method . '?app_id=' . $this->meeteo_app_id.'&time=' . time();
            $args = array(
                'headers' => array(
//                    'Authorization' => 'Bearer ' . $this->generateJWTKey(),
                    'Content-Type' => 'application/json'
                )
            );
            if ($request == "GET") {
                $args['body'] = !empty($data) ? $data : array();
                $response = wp_remote_get($request_url, $args);
            } else {
                $args['body'] = !empty($data) ? json_encode($data) : array();
                $args['method'] = "POST";
                $response = wp_remote_post($request_url, $args);
            }
            $response = wp_remote_retrieve_body($response);
            if (!$response) {
                return false;
            }
            return $response;
        }

        /**
         * Get the webinar by ID
         * @param array $args
         * @return array|bool|string|WP_Error
         */
        public function getWebinarById($args = array())
        {
            $defaults = array(
                'webinarId' => '',
            );
            $args = wp_parse_args($args, $defaults);
            return $this->sendRequest('get_webinar_by_id', $args, "GET");
        }

        /**
         * List webinars
         * @param $args
         * @return bool|mixed
         */
        public function listWebinar($args = array())
        {
            $defaults = array(
                'limit' => 20,
            );
            $args = wp_parse_args($args, $defaults);
            $args = apply_filters('meeteo_api_listWebinar', $args);
//            return $args;
            return $this->sendRequest('list_webinars', $args, "GET");
        }

        /**
         * List Services
         * @param $args
         * @return bool|mixed
         */
        public function listService($args = array())
        {
            $defaults = array(
                'page_size' => 50,
            );
            $args = wp_parse_args($args, $defaults);
            $args = apply_filters('meeteo_api_listService', $args);
            return $this->sendRequest('list_services', $args, "GET");
        }
    }

    function meeto_api()
    {
        return Meeteo_Api::instance();
    }

    meeto_api();
}