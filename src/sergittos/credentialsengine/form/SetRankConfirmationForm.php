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
use sergittos\credentialsengine\rank\Rank;
use sergittos\credentialsengine\session\OfflineSession;

class SetRankConfirmationForm extends ModalForm {

    private OfflineSession $session;
    private Rank $rank;

    public function __construct(OfflineSession $session, Rank $rank) {
        $this->session = $session;
        $this->rank = $rank;

        $name = $rank->getName();
        $username = $session->getUsername();
        parent::__construct(
            "Set {$name} rank to {$username}",
            "Are you sure that you want to set the {$name} rank to {$username}?",
            new ModalOption("Yes!"), new ModalOption("Nope")
        );
    }

    protected function onAccept(Player $player): void {
        if($this->session->hasOnlineSession()) {
            $this->session->getOnlineSession()->setRank($this->rank);
        } else {
            $this->session->setRankId($this->rank->getId());
            $this->session->save();
        }
    }

    protected function onDeny(Player $player): void {
        $player->sendForm(new UserOptionsForm($this->session));
    }

}