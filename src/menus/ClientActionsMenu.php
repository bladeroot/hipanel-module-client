<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\modules\client\models\Client;
use Yii;

class ClientActionsMenu extends \hiqdev\yii2\menus\Menu
{
    /**
     * @var Client
     */
    public $model;

    /**
     * {@inheritdoc}
     */
    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@client/view', 'id' => $this->model->id],
                'encode' => false,
            ],
            'billing' => [
                'label' => Yii::t('hipanel:client', 'Perform billing'),
                'icon' => 'fa-money',
                'url' => ['@client/perform-billing'],
                'linkOptions' => [
                    'data' => [
                        'method' => 'post',
                        'pjax' => '0',
                        'form' => 'perform-billing',
                        'params' => [
                            'Client[id]' => $this->model->id,
                        ],
                    ],
                ],
                'encode' => false,
                'visible' => Yii::$app->user->can('bill.create') && !$this->model->isDeleted(),
            ],
        ];
    }
}
