<?php

namespace App\Http\Controllers;
use App\Helpers\Common as Common;
use Auth;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Method to upload and save images
     * @param Request $request
     * @return string
     */

    public function storeAdmin(Request $request)
    {

        $image = $request->file('upload');

        $full_name = Common::translit(Auth::user()->full_name);

        $url = asset('storage/'.$full_name.'/'.date("d.m.y").'/'.$image->getClientOriginalName());
        $image->storeAs('public/'.$full_name.'/'.date("d.m.y"), $image->getClientOriginalName());

        $result = ['url' => $url, 'value' => $image->Path()];

        if ($request->CKEditorFuncNum && $request->CKEditor && $request->langCode) {
            //that handler to upload image CKEditor from Dialog
            $funcNum = $request->CKEditorFuncNum;
            $CKEditor = $request->CKEditor;
            $langCode = $request->langCode;
            $token = $request->ckCsrfToken;
            return view('admin.helper.ckeditor.upload_file', compact('result', 'funcNum', 'CKEditor', 'langCode', 'token'));
        }

       return $result['value'];
    }
}
