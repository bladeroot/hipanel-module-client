<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'ticket-settings-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<?= $form->field($model, 'ticket_emails')->hint(Yii::t('app', 'In this field you can specify to receive email notifications of ticket. By default, the notification is used for editing the main e-mail')); ?>
<?= $form->field($model, 'send_message_text')->checkbox()->hint(Yii::t('app', 'When checked, mail notification includes the text of the new message. By default, the mail has only the acknowledgment of the response and a link to the ticket. Be careful, the text can include confidential information.')); ?>
<?= $form->field($model, 'new_messages_first')->checkbox()->hint(Yii::t('app', 'When checked, new answers in the ticket will be displayed first.')); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form->end(); ?>