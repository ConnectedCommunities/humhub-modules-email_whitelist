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

use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\user\models\forms\AccountRegister;
//use humhub\modules\user\models\forms\Registration;

return [
    'id' => 'email_whitelist',
    'class' => 'humhub\modules\email_whitelist\Module',
    'namespace' => 'humhub\modules\email_whitelist',
    'events' => [
        ['class' => AdminMenu::className(), 'event' => AdminMenu::EVENT_INIT, 'callback' => ['humhub\modules\email_whitelist\Events', 'onAdminMenuInit']],
        ['class' => AccountRegister::className(), 'event' => AccountRegister::EVENT_BEFORE_VALIDATE, 'callback' => ['humhub\modules\email_whitelist\Events', 'onUniqueEMailValidator']],
        // \humhub\modules\user\authclient\BaseClient::EVENT_CREATE_USER
        // ['class' => Registration::className(), 'event' => 'register', 'callback' => ['humhub\modules\email_whitelist\Events', 'onUniqueEMailValidator']],
    ],
];
?>