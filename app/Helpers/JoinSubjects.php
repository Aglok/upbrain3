<?php namespace App\Helpers;

use App\Models\Subject;

class JoinSubjects{

    /**
     * @param string $subject
     * @return string $_subject
     * Функция добавляет к названию предмета '_' => _physics
     **/
    public static function _Subject($subject): string {
        return '_'.$subject;
    }

    /**
     * Функция возвращает список предметов
     * @return array
     **/
    public static function listSubject(): array {
        return ['math', 'physics', 'russian', 'informatics', 'english', 'history', 'social_sciences', 'chemistry'];
    }

    /**
     * @param string $subject
     * @return int
     * Функция возвращает по alias предмета, его id
     **/
    public static function getSubjectId($subject): int{
        return Subject::whereAlias($subject)->value('id');
    }
    /**
     * @param string $subject
     * @return string
     * Функция возвращает по alias предмета, его name
     **/
    public static function getSubjectName($subject): string{
        return Subject::whereAlias($subject)->value('name');
    }

    /**
     * @param string $subject
     * @return string
     * Функция получает цвет кристалла по названию предмета
     **/
    public static function getSubjectColor($subject): string{
        return Subject::whereAlias($subject)->value('color');
    }
}