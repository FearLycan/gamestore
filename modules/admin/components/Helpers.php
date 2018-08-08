<?php

namespace app\modules\admin\components;

use yii\helpers\Html;

/**
 * General app helper.
 *
 * @author Damian Brończyk <damian.bronczyk@gmail.pl>
 */
class Helpers
{
    public static function getTinyMceOptions()
    {
        return [
            //'menubar' => false,
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code",
                "insertdatetime media table paste",
                "emoticons paste textcolor colorpicker textpattern imagetools codesample toc help"
            ],

            'content_css' => [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css',
            ],
            'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor emoticons"
        ];
    }
}