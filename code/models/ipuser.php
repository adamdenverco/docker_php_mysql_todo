<?php
/*
 * IP User class
 */
class Ipuser extends Crud {

    protected $_table = 'ip_users';
    protected $_primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    /*
     * Set or create user id based on IP address
     * 
     * Note: we won't build a comprehensive user system yet.
     * So we'll log the user based on IP Address and connect
     * any content they create to that user.
     */
    public function setOrCreateUserIdConstantBasedOnIpAddress() {

        $ipaddress = '';
        $ipUserId = 0;

        // get valid IP address
        if ( $ipaddress = $this->getClientIpServer() ) {

            // Define the IP_USER_ID as a constant
            define( 'IP_USER_ADDRESS', $ipaddress );

            // try to retreive a user id based on the IP address
            $ipUserId = $this->getUserIdByIpAdddress($ipaddress);

            // use IP address to find the user ID
            if ( is_int($ipUserId) && $ipUserId > 0 ) {

                // user exists

            // or if no user ID then...
            } else {

                // define the data to be inserted in the database
                $data = [
                    'ip_address' => $ipaddress,
                    'status_id' => 1,
                    'created' => date('Y-m-d H:i:s'),
                    'updated' => date('Y-m-d H:i:s')
                ];
                // user our CRUD create model
                $ipUserId = $this->create($data);
            }

            // Define the IP_USER_ID as a constant
            define( 'IP_USER_ID', $ipUserId );

        }

    }

    public function getUserByIpAddress($ipaddress) {

        // set variables for our CRUD model
        $identifiers = ['ip_address' => $ipaddress, 'status_id' => 1];
        $orderBy = ['id' => 'DESC'];
        $limit = 1;

        // use our CRUD model to get our user data
        $returnUser = $this->read($identifiers ,$orderBy , $limit);

        // if we have some return data and not empty or false
        if ($returnUser && is_array($returnUser) && count($returnUser) > 0) {
            // we'll determine if we have one user or many
            $returnUser = ($returnUser['id']) ? $returnUser : $returnUser[0];
        }
        return $returnUser;
    }

    public function getUserIdByIpAdddress($ipaddress) {
        // set up defaults
        $returnUserId = false;
        $user = false;
        // if we find a valid user
        $user = $this->getUserByIpAddress($ipaddress);
        if ( is_array($user) && isset($user['id']) ) {
            // then set the return user id
            $returnUserId = (int) $user['id'];
        }
        return $returnUserId;
    }

    /*
    * ---------------------------------------------------------------
    * Get the user's IP address
    * 
    * Adapted from... 
    * https://stackoverflow.com/questions/15699101/
    * ---------------------------------------------------------------
    */
    public function getClientIpServer() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP']) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if($_SERVER['HTTP_X_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if($_SERVER['HTTP_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if($_SERVER['HTTP_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if($_SERVER['REMOTE_ADDR']) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return (inet_pton($ipaddress) !== false) ? strtoupper($ipaddress) : 'UNKNOWN';
    }

}