<?php

namespace app\modules\admin\models\forms;


use app\modules\admin\models\Language;

class LanguageForm extends Language
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['status'], 'in', 'range' => self::getLanguageStatuses()],
            [['name', 'short_name', 'language_tag'], 'string', 'max' => 255],
            [['name', 'short_name', 'language_tag', 'status'], 'required'],
        ];
    }
}