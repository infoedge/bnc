<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "domregtypesarr".
 *
 * @property int $id
 * @property string $typeName
 */
class Domregtypesarr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domregtypesarr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typeName'], 'required'],
            [['typeName'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typeName' => 'Type Name',
        ];
    }
}
