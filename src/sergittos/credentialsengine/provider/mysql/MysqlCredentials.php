<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\provider\mysql;


class MysqlCredentials {

    private string $hostname, $username, $password, $database;
    private int $port;

    public function __construct(string $hostname, string $username, string $password, string $database, int $port) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    static public function fromData(array $data): self {
        return new self($data["hostname"], $data["username"], $data["password"], $data["database"], $data["port"]);
    }

    public function getHostname(): string {
        return $this->hostname;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getDatabase(): string {
        return $this->database;
    }

    public function getPort(): int {
        return $this->port;
    }

}