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

    public $sourcePath = '@vendor/yadjet/datePicker/my97/assets';
    public $js = [
        'WdatePicker.js',
    ];

}
