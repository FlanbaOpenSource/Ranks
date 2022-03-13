<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\form;


use EasyUI\element\ModalOption;
use EasyUI\variant\ModalForm;
use pocketmine\player\Player;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\OfflineSession;
use sergittos\credentialsengine\utils\ConfigGetter;

class RemoveRankForm extends ModalForm {

    private OfflineSession $session;

    public function __construct(OfflineSession $session) {
        $this->session = $session;

        $username = $session->getUsername();
        parent::__construct(
            "Remove $username's rank",
            "Are you sure that you want to remove $username's rank? His/her rank will be converted to the default rank " .
            "(" . CredentialsEngine::getInstance()->getRankManager()->getDefaultRank()->getName() . ")",
            new ModalOption("Yes!"), new ModalOption("Nope")
        );
    }

    protected function onAccept(Player $player): void {
        if($this->session->hasOnlineSession()) {
            $this->session->getOnlineSession()->setRank(CredentialsEngine::getInstance()->getRankManager()->getDefaultRank());
        } else {
            $this->session->setRankId(ConfigGetter::getDefaultRankId());
            $this->session->save();
        }
    }

    protected function onDeny(Player $player): void {
        $player->sendForm(new UserOptionsForm($this->session));
    }

}