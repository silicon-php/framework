<?php

namespace Silicon\Factory;

interface ApplicationInterface
{
    public function run(): void;
    public function boot(): void;
}
