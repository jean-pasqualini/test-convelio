<?php

declare(strict_types=1);

class UserPlaceholderRender implements PlaceholderRenderInterface
{
    public function buildContext(array $data): array
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();
        $user =
            (isset($data['user']) && ($data['user'] instanceof User))
              ? $data['user']  
              : $APPLICATION_CONTEXT->getCurrentUser();

        return ['user' => $user];
    }

    public function renderFirstname(array $context): string
    {
        return ucfirst(mb_strtolower($context['user']->firstname));
    }

    public function getPlaceholders(): array
    {
        return [
            '[user:first_name]' => 'renderFirstname',
        ];
    }
}