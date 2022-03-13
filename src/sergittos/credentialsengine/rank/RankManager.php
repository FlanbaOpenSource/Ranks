<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\rank;


use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\utils\ConfigGetter;

class RankManager {

    /** @var Rank[] */
    private array $ranks = [];

    public function __construct() {
        foreach(json_decode(file_get_contents(CredentialsEngine::getInstance()->getDataFolder() . "ranks.json"), true) as $rank_data) {
            $this->addRank(new Rank($rank_data["id"], $rank_data["name"], $rank_data["color"], $rank_data["permissions"]));
        }
    }

    /**
     * @return Rank[]
     */
    public function getRanks(): array {
        return $this->ranks;
    }

    public function getRankById(string $id): ?Rank {
        return $this->ranks[$id] ?? null;
    }

    public function getDefaultRank(): ?Rank {
        return $this->getRankById(ConfigGetter::getDefaultRankId());
    }

    private function addRank(Rank $rank): void {
        $this->ranks[$rank->getId()] = $rank;
    }

}