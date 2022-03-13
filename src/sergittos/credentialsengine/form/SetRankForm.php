<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\form;


use EasyUI\variant\SimpleForm;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\OfflineSession;

class SetRankForm extends SimpleForm {

    private OfflineSession $session;

    public function __construct(OfflineSession $session) {
        $this->session = $session;
        parent::__construct("Set rank");
    }

    protected function onCreation(): void {
        foreach(CredentialsEngine::getInstance()->getRankManager()->getRanks() as $rank) {
            $this->addRedirectFormButton($rank->getName(), new SetRankConfirmationForm($this->session, $rank));
        }
    }

}