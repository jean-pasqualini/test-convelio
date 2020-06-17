<?php

declare(strict_types=1);

class QuoteSummaryPlaceholderRender implements PlaceholderRenderInterface
{
    public function buildContext(array $data): array
    {
        $quote = $data['quote'];
        // Why don't use quote object directly
        $_quoteFromRepository = QuoteRepository::getInstance()->getById($quote->id);

        return [
            'quote' => $quote,
            'quoteFromRepository' => $_quoteFromRepository,
        ];
    }

    public function renderHtml(array $data): string
    {
        return Quote::renderHtml($_quoteFromRepository);
    }

    public function renderPlaintext(array $data): string
    {
        return Quote::renderText($_quoteFromRepository);
    }

    public function getPlaceholders(): array
    {
        return [
            '[quote:summary_html]' => 'renderHtml',
            '[quote:summary]' => 'renderPlaintext',
        ];
    }
}