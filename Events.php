<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\email_whitelist;

use humhub\modules\user\models\forms\AccountRegister;
use humhub\modules\email_whitelist\models\EmailWhitelist;
use Yii;
use yii\helpers\Url;

class Events extends \yii\base\Object
{

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param type $event
     */
    public static function onAdminMenuInit($event)
    {

        $event->sender->addItem(array(
            'label' => Yii::t('EmailWhitelistModule.base', 'Email Whitelist'),
            'url' => Url::to(['/email_whitelist/admin/index']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-check-square-o"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'email_whitelist' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 550,
        ));

    }

    /**
     * Check to see that the email address provided
     * is on the white list.
     *
     * @param $event
     * @return mixed
     */
    public function onUniqueEMailValidator($event)
    {

        $canRegister = \humhub\models\Setting::Get('anonymousRegistration', 'authentication_internal');
        $registerModel = new \humhub\modules\user\models\forms\AccountRegister;

        if ($canRegister) {
            if($registerModel->load(Yii::$app->request->post())) {

                if(!EmailWhitelist::emailIsAllowed($registerModel->email)) {
                    $event->isValid = false;
                    return Yii::$app->getResponse()->redirect(Url::to(['/email_whitelist/denied/index']));
                }

            }
        }

    }

}