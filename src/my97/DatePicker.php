<?php

namespace yadjet\datePicker\my97;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * My97 DatePicker 控件类
 *
 * @author hiscaler <hiscaler@gmail.com>
 */
class DatePicker extends InputWidget
{

    const PICKER_TYPE_DATE = 'date';
    const PICKER_TYPE_DATETIME = 'datetime';
    const PICKER_TYPE_TIME = 'time';
    const PICKER_TYPE_YEAR = 'year';
    const PICKER_TYPE_YEAR_MONTH = 'year-month';

    public $form;
    public $htmlOptions = [];
    public $jsOptions = [];
    public $isTimestamp = true;

    /**
     * 时间选择方式
     * @var string
     */
    public $pickerType;

    public function init()
    {
        parent::init();
        if (!$this->pickerType) {
            $this->pickerType = static::PICKER_TYPE_DATE;
        }

        if (!isset($this->htmlOptions['class'])) {
            switch ($this->pickerType) {
                case static::PICKER_TYPE_DATETIME:
                    $class = 'datetime-picker';
                    break;
                case static::PICKER_TYPE_TIME:
                    $class = 'time-picker';
                    break;
                case static::PICKER_TYPE_YEAR:
                    $class = 'year-picker';
                    break;
                case static::PICKER_TYPE_YEAR_MONTH:
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
                case static::PICKER_TYPE_DATETIME:
                    $dateFormat .= ' ' . $timeFormat;
                    break;
                case static::PICKER_TYPE_TIME:
                    $dateFormat = $timeFormat;
                    break;
                case static::PICKER_TYPE_YEAR:
                    $dateFormat = 'yyyy';
                    break;
                case static::PICKER_TYPE_YEAR_MONTH:
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
            if ($this->isTimestamp) {
                $value = null;
                if ($this->pickerType == static::PICKER_TYPE_DATE) {
                    $value = Yii::$app->getFormatter()->asDate($this->model->{$this->attribute});
                } elseif ($this->pickerType == static::PICKER_TYPE_DATETIME) {
                    $value = Yii::$app->getFormatter()->asDatetime($this->model->{$this->attribute});
                }

                if ($value) {
                    $this->htmlOptions['value'] = $value;
                }
            }

            return $this->form->field($this->model, $this->attribute)->textInput($this->htmlOptions);
        } else {
            $this->htmlOptions += $this->options;
            return Html::textInput($this->name, $this->value, $this->htmlOptions);
        }
    }

}
