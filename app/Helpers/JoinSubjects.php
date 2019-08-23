<?php namespace App\Helpers;

use App\Models\Subject;

class JoinSubjects{

    /**
     * @param string $subject
     * @return string $_subject
     * Функция добавляет к названию предмета '_' => _physics
     **/
    public static function _Subject($subject){
        return '_'.$subject;
    }

    public static function listSubject(){
        return ['math', 'physics', 'russian', 'informatics', 'english', 'history', 'social_sciences', 'chemistry'];
    }

    /**
     * @param string $subject
     * @return int
     * Функция возвращает по alias предмета, его id
     **/
    public static function getSubjectId($subject){
        return Subject::whereAlias($subject)->value('id');
    }
    /**
     * @param string $subject
     * @return int
     * Функция возвращает по alias предмета, его name
     **/
    public static function getSubjectName($subject){
        return Subject::whereAlias($subject)->value('name');
    }
}