<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\session;


use sergittos\credentialsengine\CredentialsEngine;

class BaseSession {

    protected string $username;
    protected string $rank_id;
    protected int $coins;

    public function __construct(string $username) {
        $this->username = strtolower($username);
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getRankId(): string {
        return $this->rank_id;
    }

    public function getCoins(): int {
        return $this->coins;
    }

    public function setRankId(string $rank_id): void {
        $this->rank_id = $rank_id;
    }

    public function setCoins(int $coins): void {
        $this->coins = $coins;
    }

    public function save(): void {
        CredentialsEngine::getInstance()->getProvider()->saveSession($this);
    }

}