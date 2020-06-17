<?php

declare(strict_types=1);

class QuoteDestinationPlaceholderRender implements PlaceholderRenderInterface
{
    public function buildContext(array $data): array
    {
        $quote = $data['quote'];
        $destination = DestinationRepository::getInstance()->getById($quote->destinationId);
        $usefulObject = SiteRepository::getInstance()->getById($quote->siteId);
        // Why don't use quote object directly
        $_quoteFromRepository = QuoteRepository::getInstance()->getById($quote->id);

        return [
            'usefulObject' => $usefulObject,
            'destination' => $destination,
            'quote' => $quote,
            'quoteFromRepository' => $_quoteFromRepository,
        ];
    }

    public function renderLink(array $context): string
    {
        return $context['usefulObject']->url . '/' . $context['destination']->countryName . '/quote/' . $context['quoteFromRepository']->id;
    }

    public function renderName(array $context): string
    {
       return $context['destination']->countryName;
    }

    public function getPlaceholders(): array
    {
        return [
            '[quote:destination_link]' => 'renderLink',
            '[quote:destination_name]' => 'renderName',
        ];
    }
}