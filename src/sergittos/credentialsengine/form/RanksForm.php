<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\form;


use EasyUI\variant\SimpleForm;

class RanksForm extends SimpleForm {

    public function __construct() {
        parent::__construct("CredentialsEngine");
    }

    protected function onCreation(): void {
        $this->addRedirectFormButton("Manage user", new ManageUserForm());
    }

}