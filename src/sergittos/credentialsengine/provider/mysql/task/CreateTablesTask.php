<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\provider\mysql\task;


use mysqli;

class CreateTablesTask extends MysqlTask {

    public function execute(mysqli $mysqli): void {
        $mysqli->query(
            "CREATE TABLE IF NOT EXISTS users (
                username VARCHAR(16) PRIMARY KEY,
                rank_id VARCHAR(100),
                coins INT
            )"
        );
    }

}