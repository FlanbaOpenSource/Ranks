<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\session;


use DidntPot\LobbyCore;
use DidntPot\player\session\SessionHandler;
use DidntPot\player\session\SessionIdentifier;
use pocketmine\player\Player;
use sergittos\credentialsengine\rank\Rank;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\utils\ColorUtils;
use sergittos\credentialsengine\utils\ConfigGetter;
use sergittos\credentialsengine\utils\PermissionsUtils;

class Session extends BaseSession {

    private Player $player;
    private Rank $rank;

    public function __construct(Player $player) {
        $this->player = $player;
        parent::__construct($player->getName());
        CredentialsEngine::getInstance()->getProvider()->loadSession($this);
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getRank(): Rank {
        return $this->rank;
    }

    public function setRank(Rank $rank): void {
        $this->rank_id = $rank->getId();
        $this->rank = $rank;

        if(class_exists(LobbyCore::class)) {
            SessionHandler::getSession($this->player, SessionIdentifier::PLAYER_SESSION)->updateScoreboard();
        }
        $this->updateNameTag();
        PermissionsUtils::updateSessionPermissions($this);
    }

    private function updateNameTag(): void {
        $this->player->setNameTag(ColorUtils::translate(str_replace(
            ["{level}", "{rank}", "{player}"],
            ["10", $this->rank->getColor() . $this->rank->getName(), $this->player->getName()],
            ConfigGetter::getNameTagFormat()
        )));
    }

}