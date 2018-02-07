<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Input;
use Request;
use Auth;
use Storage;
use Intervention\Image\Facades\Image;


class UploadImage{

    /**
     * @var string
     * Директория для upload изображения
     */
    public $dir;

    /**
     * Принимаем изображение в base64, получает тело создаём название
     * Загружает полученные изображения в storage/messages
     * @param $name
     *
     * @return string
     */
    public function uploadImage($name){

        $strImageName = '';

        //Транслителируем в латиницу
        $full_name = $this->translit(Auth::user()->full_name);
        $dir = $this->dir.'/'.$full_name;
        dd(Request::has('upload'));
        if(Input::has($name)){

            $images = Request::input($name);

            foreach ($images as $n => $image):

                $imageName = $this->genNameImage($n, $image);

                $strImageName.= $imageName.'|';

                //Директория messages/name_surname

                //Для image->save($path) путь куда нужно сохранить изображение
                $path = public_path('images/'.$dir.'/'.$imageName);

                //Создаём директорию 755
                if (!Storage::disk('images')->exists($dir)) {
                    Storage::disk('images')->makeDirectory($dir);
                }

                $this->fitImage($image, 800, 800, $path);

            endforeach;
        }

        return (Object)['images' => substr($strImageName, 0, -1), 'dir' => $dir];
    }
    /**
     * Изменяет размер изображения
     * @param $image
     * @param $width
     * @param $height
     * @param $path
     *
     * @return Image
     */
    public function fitImage($image, $width, $height, $path){

        return Image::make($image)->fit($width, $height)->save($path);
    }

    /**
     * Генерация имени файла с сохранением расширения
     * @param $n
     * @param $imageBody
     * @return string
     */
    public function genNameImage($n, $imageBody){

        $fileName = date("dmy_His").'_'.$n;

        // определяем формат файла
        preg_match('#data:image\/(png|jpg|jpeg|gif);#', $imageBody, $fileTypeMatch);
        $fileType = $fileTypeMatch[1];

        return $fileName . '.' . $fileType;
    }

    /**
     * Транслитерация строк, добавилено пробел(' ') заменяется на '_'
     * @param $text
     * @return string
     */
    public function translit($text) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_');
        return str_replace($rus, $lat, $text);
    }
}