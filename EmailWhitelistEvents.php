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

class EmailWhitelistEvents{

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param type $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('EmailWhitelistModule.base', 'Email Whitelist'),
            'url' => Yii::app()->createUrl('//email_whitelist/admin'),
            'group' => 'manage',
            'icon' => '<i class="fa fa-check-square-o"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'email_whitelist' && Yii::app()->controller->id == 'admin'),
            'sortOrder' => 550,
        ));
    }

    public static function onUniqueEMailValidator($event) 
    {   

        $model = new AccountRegisterForm;
        $allowed = EmailWhitelist::toArray();

        if (isset($_POST['AccountRegisterForm'])) {
            $model->attributes = $_POST['AccountRegisterForm'];
        
            if ($model->validate()) {

                // Make sure the address is valid
                if (filter_var($model->email, FILTER_VALIDATE_EMAIL)) {
                    $domain = strtolower(array_pop(@explode('@', $model->email)));
                    if (! in_array($domain, $allowed)) { // email not whitelisted

                        // empty $_POST['AccountRegisterForm'] so it doesn't submit anything
                        $_POST['AccountRegisterForm'] = null;

                        Yii::app()->request->redirect(Yii::app()->createUrl('//email_whitelist/denied', array()));
                        // TODO
                        // Redirect them to an error page
                        


                        // render the invalid email domain notification
                        // Yii::app()->getController()->widget('application.modules.email_whitelist.widgets.InvalidEmailDomain', array()); 
                        // Yii::app()->getController()->widget('application.modules.email_whitelist.widgets.InvalidEmailDomain', array(), true); -->
                    }
                }

            }

        }

    }

}