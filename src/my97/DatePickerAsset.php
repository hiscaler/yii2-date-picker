<?php

namespace yadjet\datePicker\my97;

use yii\web\AssetBundle;

/**
 * Date picker asset
 * 
 * @author hiscaler<hiscaler@gmail.com>
 */
class DatePickerAsset extends AssetBundle
{

    public $sourcePath = '@vendor/yadjet/yii2-date-picker/src/my97/assets';
    public $js = [
        'WdatePicker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
