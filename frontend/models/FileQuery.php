<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[UserFileRecord]].
 *
 * @see UserFileRecord
 */
class FileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserFileRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserFileRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}