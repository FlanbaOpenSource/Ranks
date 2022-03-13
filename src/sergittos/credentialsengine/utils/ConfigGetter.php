<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\utils;


use sergittos\credentialsengine\CredentialsEngine;

class ConfigGetter {

    static private array $config_data;

    static public function init(): void {
        self::$config_data = CredentialsEngine::getInstance()->getConfig()->getAll();
    }

    static private function get(string $key): mixed {
        return self::$config_data[$key] ?? null;
    }

    static public function getDefaultRankId(): string {
        return self::get("default-rank-id");
    }

    static public function getChatFormat(): string {
        return self::get("chat-format");
    }

    static public function getNameTagFormat(): string {
        return self::get("nametag-format");
    }

    static public function getMysqlCredentials(): array {
        return self::get("mysql-credentials");
    }

}