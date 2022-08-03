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
    public $eppcode;
    public $renewPrice;
    public $transferPrice;

    public $confirmtrx;

    public function rules()
    {
        return [
            // trxOptn and domain are both required
            [['trxoptn', 'domain'], 'required'],
            [['eppcode'],'required','on'=>'trxin'],
            [['eppcode'],'string'],
            [['trxoptn','confirmtrx'],'integer'],
            [['confirmtrx'], 'required', 'on'=>'trxout'],
            [['renewPrice','transferPrice'],'double'],
        ];
    }

    public function attributes()
    {
        return[
            'trxoptn'=>'Option',
            'domain'  => 'Domain(s)',
            'eppcode' =>'Authorization/ EPP code',
            'renewPrice'=>'Renewal Price',
            'transferPrice'=>'Transfer Price',
            'confirmtrx'=>'Confirm Transfer',
        ];
    }

    public function scenarios(){
        return[
            'default'=>['trxoptn', 'domain'],
            'trxin'=>['eppcode'],
            'trxout'=>['confirmtrx'],
        ];
    }
}