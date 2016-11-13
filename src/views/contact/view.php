<?php

use hipanel\helpers\Url;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\widgets\Verification;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * @var \hipanel\modules\client\models\Contact $model
 */

$this->title = Inflector::titleize($model->name, true);
$this->params['subtitle'] = Yii::t('hipanel:client', 'Contact detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:client', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

FlagIconCssAsset::register($this);

?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]) ?>
            <div class="profile-user-img text-center">
                <?= $this->render('//layouts/gravatar', ['email' => $model->email, 'size' => 120]) ?>
            </div>
            <p class="text-center">
                <span class="profile-user-role"><?= $this->title ?></span>
                <br>
                <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
            </p>

            <div class="profile-usermenu">
                <ul class="nav">
                    <li>
                        <?= Html::a('<i class="fa fa-edit"></i>' . Yii::t('hipanel', 'Edit'), ['update', 'id' => $model->id]) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-paperclip"></i>' . Yii::t('hipanel:client', 'Documents'), ['attach-files', 'id' => $model->id]) ?>
                    </li>
                <?php if (Yii::getAlias('@domain', false) && $model->used_count > 0) : ?>
                    <li>
                        <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('hipanel:client', 'Used for {n, plural, one{# domain} other{# domains}}', ['n' => $model->used_count]), Url::toSearch('domain', ['client_id' => $model->client_id])) ?>
                    </li>
                <?php endif ?>
                </ul>
            </div>
        <?php Box::end() ?>

        <?php if (Yii::$app->user->can('manage')) : ?>
            <?php $box = Box::begin(['renderBody' => false]) ?>
                <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Yii::t('hipanel:client', 'Verification status')) ?>
                <?php $box->endHeader() ?>
                <?php $box->beginBody() ?>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <?php foreach (['name', 'address', 'email', 'voice_phone', 'fax_phone'] as $attribute) : ?>
                                <tr>
                                    <th><?= $model->getAttributeLabel($attribute) ?></th>
                                    <td>
                                        <?= Verification::widget([
                                            'model' => $model->getVerification($attribute),
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php $box->endBody() ?>
            <?php $box->end() ?>
        <?php endif ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('hipanel:client', 'Contact information')) ?>
                        <?php $box->beginTools() ?>
                            <?= Html::a(Yii::t('hipanel', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                        <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'seller_id',
                                'client_id',
                                ['attribute' => 'name'],
                                'birth_date',
                                'email_with_verification', 'abuse_email',
                                'voice_phone', 'fax_phone',
                                'messengers', 'other', 'social_net',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>

                <?php $box = Box::begin([
                    'renderBody' => false,
                    'collapsed' => empty($model->vat_number) && empty($model->vat_rate),
                    'collapsable' => true,
                    'title' => Yii::t('hipanel:client', 'Tax information'),
                ]) ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'vat_number', 'vat_rate', 'tax_comment',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('hipanel:client', 'Postal information')) ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'first_name', 'last_name', 'organization',
                                'street', 'city', 'province', 'postal_code', 'country',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>

                <?php $box = Box::begin([
                    'renderBody' => false,
                    'collapsed' => true,
                    'title' => Yii::t('hipanel:client', 'Additional information'),
                ]) ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'passport_date', 'passport_no', 'passport_by',
                                'organization_ru', 'inn', 'kpp', 'director_name', 'isresident',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>
            </div>
        </div>
    </div>
</div>
