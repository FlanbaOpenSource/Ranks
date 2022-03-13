<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\form;


use EasyUI\variant\SimpleForm;
use sergittos\credentialsengine\session\OfflineSession;

class UserOptionsForm extends SimpleForm {

    private OfflineSession $session;

    public function __construct(OfflineSession $session) {
        $this->session = $session;
        parent::__construct("User options", "What do you want to do?");
    }

    protected function onCreation(): void {
        $this->addRedirectFormButton("Set rank", new SetRankForm($this->session));
        $this->addRedirectFormButton("Remove rank", new RemoveRankForm($this->session));
    }

}