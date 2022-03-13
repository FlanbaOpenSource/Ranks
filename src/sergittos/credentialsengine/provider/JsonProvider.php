<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\provider;


use pocketmine\utils\Config;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\BaseSession;
use sergittos\credentialsengine\session\Session;
use sergittos\credentialsengine\utils\ConfigGetter;

class JsonProvider extends Provider {

    public function __construct() {
        $players_dir = CredentialsEngine::getInstance()->getDataFolder() . "players";
        if(!is_dir($players_dir)) {
            mkdir($players_dir);
        }
    }

    public function loadSession(BaseSession $session): void {
        $rank_id = $this->getSessionConfig($session)->get("rank_id");
        if($session instanceof Session) {
            $session->setRank(CredentialsEngine::getInstance()->getRankManager()->getRankById($rank_id));
            return;
        }
        $session->setRankId($rank_id);
    }

    public function saveSession(BaseSession $session): void {
        $config = $this->getSessionConfig($session);
        $config->set("rank_id", $session->getRankId());
        $config->save();
    }

    private function getSessionConfig(BaseSession $session): Config {
        $config = new Config(CredentialsEngine::getInstance()->getDataFolder() . "players/" . $session->getUsername() . ".json", Config::JSON);
        if(!$config->exists("rank_id")) {
            $config->set("rank_id", ConfigGetter::getDefaultRankId());
            $config->save();
        }
        return $config;
    }

}