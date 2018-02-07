<?php namespace App\Helpers;

class JoinSubjects{

    /**
     * @param string $subject
     * @return string $_subject
     * Функция добавляет к названию предмета '_' => _physics
     **/
    public static function _Subject($subject){

        $_subject = '_'.$subject;
        if($subject == 'math') $_subject = '';

        return $_subject;
    }
}