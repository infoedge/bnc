<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Options- domain 
 */
class Dnsrecord extends Model
{
    public $domainName;
    public $host;
    public $fqdn;
    public $type;
    public $answer;
    public $ttl;
    public $priority;

    public function rules()
    {
        return[
            [['domainName','host','fqdn','type','answer'],'string'],
            [['ttl','priority'],'integer'],
            [['type']],
        ];
    }
}
?>