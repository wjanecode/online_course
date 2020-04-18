<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
//    // 重定义构造器使 message 变为必须被指定的属性
//    public function __construct($message, $code = 0) {
//        // 自定义的代码
//
//        // 确保所有变量都被正确赋值
//        parent::__construct($message, $code);
//    }
//
//    // 自定义字符串输出的样式 */
//    public function __toString() {
//        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
//    }
//
//    public function customFunction() {
//        echo "A Custom function for this type of exception\n";
//    }

    //调用渲染方法render(),会渲染到response()中
    public function render(  ) {
        return '你没有权限';
    }
}
