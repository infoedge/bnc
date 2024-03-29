<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Options- domain 
 */
class Dnslist extends Model
{
    public $domainName;
    public $locked;
    public $autorenewEnabled;
    public $expireDate;
    public $createDate;

    public function rules()
    {
        return[
            [['domainName'],'string'],
            [['locked','autorenewEnabled'], 'boolean'],
            [['expireDate','createDate'],'date'],
        ];
    }
    public function attributes()
    {
        return[
            'domainName'=>'Domain Name',
            'locked'=>'Is locked?',
            'autorenewEnabled'=>'Is Auto-renew Enabled?',
            'expireDate'=>'Expiry Date',
            'createDate'=> 'create Date',
        ];
    }

    public function scenarios()
    {
        return[
            'default'=>['domainName','locked','autorenewEnabled'],
        ];
    }
}
?>