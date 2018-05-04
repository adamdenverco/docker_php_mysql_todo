<?php 
/*
 * Todo class
 */
class Todo extends Crud {

    protected $_table = 'todos';
    protected $_primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getUserActiveTodos($id = null) {
        $identifiers = [
            'ip_user_id' => IP_USER_ID,
            'status_id' => 1
        ];
        $orderBy = [
            'column' => 'date_created', 
            'order' => 'ASC'
        ];
        if ( $id = validIntegerOrZero($id) ) {
            $identifiers['todo_id'] = $id;
            $orderBy['limit'] =  1;
        }
        return $this->read($identifiers, $orderBy);
    }

    public function changeComplete($id = null) {
        // prep result to return
        $result = [];

        // get a valid todo item or false
        if ( $todoItem = $this->returnValidItemOrFalse($id) ) {
            // set the WHERE variable for the SQL UPDATE
            $identifiers = [
                'todo_id' => $todoItem['todo_id'],
                'ip_user_id' => IP_USER_ID,
                'status_id' => 1
            ];

            // set the SET values for the SQL UPDATE
            $data = [
                'completed' => ($todoItem['completed'] == 1) ? 0 : 1,
                'date_modified' => dateForDatabase()
            ];

            // attempt to update the Todo Item
            if ( $this->update($identifiers,$data) ) {
                $result = [
                    'status' => 'success',
                    'message' => ($data['completed']) ? 'You marked a todo item "complete".' :
                        'You marked a todo item "not complete".'
                ];
            }

        }

        // if our result is not a SUCCESS, set a basic error message
        if ( isset($result['status']) && $result['status'] != 'success' ) {
            $result = [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ];
        }

        return $result;
    }

    public function deleteItem($id = null) {

        // prep result to return
        $result = [];

        // get a valid todo item or false
        if ( $todoItem = $this->returnValidItemOrFalse($id) ) {

            // set the WHERE variable for the SQL UPDATE
            $identifiers = [
                'todo_id' => $todoItem['todo_id'],
                'ip_user_id' => IP_USER_ID,
            ];

            // set the SET values for the SQL UPDATE
            $data = [
                'status_id' => -1,
                'date_modified' => dateForDatabase()
            ];

            // attempt to update the Todo Item
            if ( $this->update($identifiers,$data) ) {
                $result = [
                    'status' => 'success',
                    'message' => 'You deleted a todo item.'
                ];
            }

        }

        // if our result is not a SUCCESS, set a basic error message
        if ( isset($result['status']) && $result['status'] != 'success' ) {
            $result = [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ];
        }

        return $result;

    }

    public function newItem($data = null) {

        $result = [];

        // set the SET values for the SQL INSERT
        $data = [
            'ip_user_id' => IP_USER_ID,
            'content' => htmlspecialchars($data['content'], ENT_QUOTES, 'UTF-8'),
            'status_id' => 1,
            'completed' => 0,
            'date_created' => dateForDatabase(),
            'date_modified' => dateForDatabase()
        ];

        if ( $this->create($data) ) {
            $result = [
                'status' => 'success',
                'message' => 'You created a new todo item.'
            ];
        }

        // if our result is not a SUCCESS, set a basic error message
        if ( isset($result['status']) && $result['status'] != 'success' ) {
            $result = [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ];
        }

        return $result;
    }

    public function editItem($data = []) {

        // prep result to return
        $result = [];

        // get a valid todo item or false
        if ( $todoItem = $this->returnValidItemOrFalse($data['todo_id']) ) {
            // set the WHERE variable for the SQL UPDATE
            $identifiers = [
                'todo_id' => $todoItem['todo_id'],
                'ip_user_id' => IP_USER_ID,
                'status_id' => 1
            ];

            // set the SET values for the SQL UPDATE
            $data = [
                'content' => trim( htmlspecialchars($data['content'], ENT_QUOTES, 'UTF-8') ),
                'date_modified' => dateForDatabase()
            ];

            // attempt to update the Todo Item
            if ( $this->update($identifiers,$data) ) {
                $result = [
                    'status' => 'success',
                    'message' => 'You edited a todo item.'
                ];
            }
        }

        // if our result is not a SUCCESS, set a basic error message
        if ( isset($result['status']) && $result['status'] != 'success' ) {
            $result = [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ];
        }

        return $result;
    }

    public function returnValidItemOrFalse($id = null) {
        $returnArrayOrFalse = false;
        // do we have a valid integer for the id
        if ( $id = validIntegerOrZero($id) ) {
            // get our single todo item
            // (a single item array entry)
            $todoitem = $this->getUserActiveTodos($id);
            // make sure we have the right info
            $returnArrayOrFalse = (is_array($todoitem) && isset($todoitem[0]['todo_id'])) ? $todoitem[0] : false;
        }
        return $returnArrayOrFalse;
    }

}