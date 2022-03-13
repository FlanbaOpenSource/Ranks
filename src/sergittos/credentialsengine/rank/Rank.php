<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\rank;


class Rank {

    private string $id;
    private string $name;
    private string $color;

    /** @var string[] */
    private array $permissions;

    public function __construct(string $id, string $name, string $color, array $permissions) {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->permissions = $permissions;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getColor(): string {
        return $this->color;
    }

    /**
     * @return string[]
     */
    public function getPermissions(): array {
        return $this->permissions;
    }

}