<?php

namespace frontend\models;

use \frontend\models\base\UserFileRecord as BaseFileRecord;

/**
 * This is the model class for table "user_files".
 */
class UserFileRecord extends BaseFileRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'file_name'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['file_name', 'title'], 'string', 'max' => 255]
        ]);
    }
	
}
