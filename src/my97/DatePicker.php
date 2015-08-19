<?php

namespace yadjet\datePicker\my97;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

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

    /**
     * 时间选择方式
     * @var string
     */
    public $pickerType = 'date';

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
                case 'year':
                    $class = 'year-picker';
                    break;
                case 'year-month':
                    $class = 'year-month-picker';
                    break;
                default :
                    $class = 'date-picker';
            }
            $this->htmlOptions['class'] = "{$class} form-control";
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
                case 'year':
                    $dateFormat = 'yyyy';
                    break;
                case 'year-month':
                    $dateFormat = 'yyyyMM';
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
            $this->htmlOptions += $this->options;
            return Html::textInput($this->name, $this->value, $this->htmlOptions);
        }
    }

}
