<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client;

use Yii;

class SidebarMenu extends \hiqdev\menumanager\Menu
{
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'  => ['dashboard'],
    ];

    public function items()
    {
        return [
            'clients' => [
                'label'   => Yii::t('hipanel', 'Clients'),
                'url'     => ['/client/client/index'],
                'icon'    => 'fa-group',
                'visible' => function () { return Yii::$app->user->can('support') ?: false; },
                'items'   => [
                    'clients' => [
                        'label' => Yii::t('hipanel', 'Clients'),
                        'url'   => ['/client/client/index'],
                    ],
//                  'mailing' => [
//                      'label' => Yii::t('hipanel', 'Mailing'),
//                      'url'   => ['/client/mailing/index'],
//                  ],
//                  'articles' => [
//                      'label' => Yii::t('hipanel', 'News and articles'),
//                      'url'   => ['/client/article/index'],
//                  ],
                    'contacts' => [
                        'label' => Yii::t('hipanel', 'Contacts'),
                        'url'   => ['/client/contact/index'],
                    ],
                ],
            ],
        ];
    }
}
