<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\provider\mysql\task;


use pocketmine\Server;
use sergittos\credentialsengine\provider\mysql\MysqlProvider;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\BaseSession;
use sergittos\credentialsengine\session\SessionFactory;
use sergittos\credentialsengine\utils\ConfigGetter;
use mysqli;

class LoadSessionTask extends MysqlTask {

    private string $username;
    private string $default_rank_id;

    public function __construct(MysqlProvider $provider, BaseSession $session) {
        $this->username = $session->getUsername();
        $this->default_rank_id = ConfigGetter::getDefaultRankId();
        parent::__construct($provider);
    }

    public function execute(mysqli $mysqli): void {
        $username = $this->username;
        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        $rows = [];
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if(empty($rows)) {
            $rank_id = $this->default_rank_id;
            $coins = 0;
            $statement = $mysqli->prepare("INSERT INTO users (username, rank_id, coins) VALUES (?, ?, ?)");
            $statement->bind_param("ssi", $username, $rank_id, $coins);
            $statement->execute();

            $this->setResult(["rank_id" => $rank_id, "coins" => $coins]);
            return;
        }
        $this->setResult($rows[0]);
    }

    public function onCompletion(): void {
        $player = Server::getInstance()->getPlayerExact($this->username);
        if($player !== null) {
            $result = $this->getResult();
            $session = SessionFactory::getSession($player);
            $session->setRank(CredentialsEngine::getInstance()->getRankManager()->getRankById($result["rank_id"]));
            $session->setCoins($result["coins"]);
        }
    }

}