<?php

namespace App;

interface BasicContract
{
    public function getName():string;

    public function getAge():int;

    public function  isDead(): bool;
}