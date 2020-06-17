<?php

declare(strict_types=1);

interface PlaceholderRenderInterface {

    public function buildContext(array $data): array;

    public function getPlaceholders(): array;
}