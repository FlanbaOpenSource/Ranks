<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\session;


use pocketmine\Server;

class OfflineSession extends BaseSession {

    public function hasOnlineSession(): bool {
        return $this->getOnlineSession() !== null;
    }

    public function getOnlineSession(): ?Session {
        $player = Server::getInstance()->getPlayerExact($this->username);
        if($player !== null) {
            return SessionFactory::getSession($player);
        }
        return null;
    }

}