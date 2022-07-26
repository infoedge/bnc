<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Options- domain 
 */
class Options extends Model
{
    public $trxoptn;
    public $domain;

    public function rules()
    {
        return [
            // trxOptn and domain are both required
            [['trxoptn', 'domain'], 'required'],
            
        ];
    }

    public function attributes()
    {
        return[
            'trxoptn'=>'Option',
            'domain'  => 'Domain(s)',
        ];
    }
}