<?php namespace App\Helpers;

class ResTools {
    const PER_PAGE = 15;

    public static $ERROR_CODES = [
        'OK' => 200,
        'BAD_REQUEST' => 400,
        'UNAUTHORIZED' => 401,
        'FORBIDEN' => 403,
        'NOT_FOUND' => 404,
        'METHOD_NOT_ALLOWED' => 405,
        'INTERNAL_SERVER_ERROR' => 500,
    ];

    public static function resList($data, $extra=[]){
        $result = [
            'success' => true,
            'status_code' => self::$ERROR_CODES['OK'],
            'message' => null,
            'data' => [
                'items' => [],
                '_meta' => [
                    'curren_page' => 1,
                    'page_count' => 0
                ],
                '_links' => [
                    'next_link' => '',
                    'last_link' => '',
                    'self_link' => '',
                ],
            ],
            'extra' => $extra
        ];
        return $result;
    }

    public static function resObj($data, $message=null){
        $result = [
            'success' => true,
            'status_code' => 200,
            'message' => $message,
            'data' => null
        ];
        $result['data'] = count($data) == 0 ? null : $data;
        return $result;
    }

    public static function resErr($errors, $statusCode=null){
        if($statusCode == null){
            $statusCode = self::$ERROR_CODES['BAD_REQUEST'];
        }
        $result = [
            'success' => false,
            'status_code' => $statusCode,
            'message' => '',
            'data' => null,
        ];

        if(gettype($errors) ==  'string'){
            $result['message'] = [];
            $result['message']['common'] = $errors;
        }else{
            $result['message'] = $errors;
        }
        return $result;
    }
}
