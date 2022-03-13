<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\provider\mysql\task;


use pocketmine\scheduler\AsyncTask;
use sergittos\credentialsengine\provider\mysql\MysqlCredentials;
use sergittos\credentialsengine\provider\mysql\MysqlProvider;
use mysqli;

abstract class MysqlTask extends AsyncTask {

    private MysqlCredentials $credentials;

    public function __construct(MysqlProvider $provider) {
        $this->credentials = $provider->getCredentials();
    }

    public function onRun(): void {
        $mysqli = new mysqli(
            $this->credentials->getHostname(),
            $this->credentials->getUsername(),
            $this->credentials->getPassword(),
            $this->credentials->getDatabase(),
            $this->credentials->getPort()
        );
        $this->execute($mysqli);
        $mysqli->close();
    }

    abstract public function execute(mysqli $mysqli): void;

}