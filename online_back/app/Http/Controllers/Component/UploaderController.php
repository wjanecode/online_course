<?php

namespace App\Http\Controllers\Component;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploaderController extends Controller
{
    //允许上传的类型
    protected  $type = ['jpg','jpeg','png','gif','bmp'];
    //文件上传存放目录
    protected $upload_dir = "./images";

    public function uploader(Request $request) {

        /**
        //dd($_FILES['file']['name']);
        //php原生
        //判断上传文件是否存在
        if(isset($_FILES['file'])) {
            #后缀
            $fileext = substr( strrchr( $_FILES['file']['name'], '.' ), 1 );
            //判断是否在允许范围
            if ( in_array( $fileext, $this->type ) ) {

                #获取临时位置
                $tmp_name = $_FILES['file']['tmp_name'];

                do
                {
                    #拼接新文件名,日期加数字随机,加后缀
                    $name = date( 'Y-m-d-h' ) . '-' . random_int( 000000, 99999999 ) . '.' . $fileext;
                    #新路径加文件名
                    $upload_file = $this->upload_dir . '/' . $name;
                }
                #避免图片重名,有重名的就重新赋随机值
                while(is_file($upload_file));

                #移动到upload,并重命名
                if ( move_uploaded_file( $tmp_name, $upload_file ) ) {
                    //返回文件路径
                    return response()->json(['status'=>201,'msg'=>'图片上传成功','path'=>$upload_file]);
                }

            } else {
                //不在范围内
                echo response()->json(['status'=>0,'msg'=>'图片类型不允许','pat'=>'']);
            }
        }
         * */

            //laravel
            //文件上传
            //获取文件
            $file = $request->file('file');

            //保存文件
            $filename = $this->upload($file);
            if ($filename){
                return response()->json(['status'=>'200','msg'=>$filename]);
            }
            return response()->json(['status'=>'0','msg'=>'上传失败']);

    }


    /**
     * 文件验证
     * @param $file
     * @param string $disk
     * @return string $fileName | boolean false
     */
    public function upload($file,$disk = 'public'  ) {
        //1,文件是否上传成功
        if(! $file->isValid()){
            return false;
        }

        //2,是否符合文件类型要求
        $fileExtension = $file->getClientOriginalExtension();
        if(! in_array($fileExtension,$this->type)){
            return false;
        }

        // 3.判断大小是否符合 2M
        $tmpFile = $file->getRealPath();
        if (filesize($tmpFile) >= 2048000) {
            return false;
        }

        // 4.是否是通过http请求表单提交的文件
        if (! is_uploaded_file($tmpFile)) {
            return false;
        }

        // 5.每月一个文件夹,分开存储, 生成一个随机文件名
        $fileName = date('Y-m').'/'.md5(time()).mt_rand(0,9999).'.'. $fileExtension;
        if (Storage::disk($disk)->put($fileName, file_get_contents($tmpFile)) ){
            return Storage::url($fileName);
        }
    }

    public function filelists( $id) {
        //返回图片的地址
        return url(Course::find($id)->cover);
    }
}
