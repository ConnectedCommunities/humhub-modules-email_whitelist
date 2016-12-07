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

Yii::app()->moduleManager->register(array(
    'id' => 'email_whitelist',
    'class' => 'application.modules.email_whitelist.EmailWhitelistModule',
    'import' => array(
        'application.modules.email_whitelist.*',
        'application.modules.email_whitelist.models.*',

        'application.modules_core.user.models.*',
        'application.modules_core.user.controllers.*', 
    ),
    'events' => array(
    	array('class' => 'AdminMenuWidget', 'event' => 'onInit', 'callback' => array('EmailWhitelistEvents', 'onAdminMenuInit')),
    	array('class' => 'AccountRegisterForm', 'event' => 'uniqueEMailValidator', 'callback' => array('EmailWhitelistEvents', 'onUniqueEMailValidator')),
    	array('class' => 'AuthController', 'event' => 'onBeforeAction', 'callback' => array('EmailWhitelistEvents', 'onUniqueEMailValidator')),
    	// beforeSave
    ),
));
?>