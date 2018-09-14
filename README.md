# About
Date picker for Yii2

## Install
Use composer, you only use follow command in you CLI.

```bash
composer require "yadjet/yii2-date-picker:~1.0.0"
```

## Usage
```php
<?=
\yadjet\datePicker\my97\DatePicker::widget([
    'form' => $form,
    'model' => $model,
    'attribute' => 'post_datetime',
    'pickerType' => 'datetime',
]);
?>
```