<?php

namespace yadjet\datePicker\my97;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * My97DatePicker 控件类
 *
 * @author hiscaler <hiscaler@gmail.com>
 */
class DatePicker extends InputWidget
{

    public $form;
    public $htmlOptions = [];
    public $jsOptions = [];
    public $pickerType = 'date'; // 时间选择方式

    public function init()
    {
        parent::init();
        if (!isset($this->htmlOptions['class'])) {
            switch ($this->pickerType) {
                case 'datetime':
                    $class = 'datetime-picker';
                    break;
                case 'time':
                    $class = 'time-picker';
                    break;
                default :
                    $class = 'date-picker';
            }
            $this->htmlOptions['class'] = $class;
        }
        if (!isset($this->jsOptions['dateFmt'])) {
            $dateFormat = 'yyyy-MM-dd';
            $timeFormat = 'HH:mm:ss';
            switch ($this->pickerType) {
                case 'datetime':
                    $dateFormat .= ' ' . $timeFormat;
                    break;
                case 'time':
                    $dateFormat = $timeFormat;
                    break;
            }

            $this->jsOptions['dateFmt'] = $dateFormat;
        }
        if (!isset($this->jsOptions['lang'])) {
            $this->jsOptions['lang'] = strtolower(Yii::$app->language);
        }
        if (!in_array(strtolower($this->jsOptions['lang']), ['en', 'zh-cn', 'zh-tw'])) {
            $this->jsOptions['lang'] = 'en';
        }
    }

    public function run()
    {
        $id = $this->options['id'];
        $view = $this->getView();
        DatePickerAsset::register($view);
        $js = strtr('WdatePicker({options});', ['{options}' => Json::encode($this->jsOptions)]);
        $view->registerJs("jQuery(document).on('click', '#{$id}', function() {{$js}});");
        if ($this->hasModel()) {
            return $this->form->field($this->model, $this->attribute)->textInput($this->htmlOptions);
        } else {
            list($name, $id) = $this->resolveNameID();
            return Html::textField($name, $this->value, $this->htmlOptions);
        }
    }

}
