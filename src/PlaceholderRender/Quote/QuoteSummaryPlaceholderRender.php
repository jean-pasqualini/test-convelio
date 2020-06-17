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

    public function renderHtml(array $context): string
    {
        return Quote::renderHtml($context['quoteFromRepository']);
    }

    public function renderPlaintext(array $context): string
    {
        return Quote::renderText($context['quoteFromRepository']);
    }

    public function getPlaceholders(): array
    {
        return [
            '[quote:summary_html]' => 'renderHtml',
            '[quote:summary]' => 'renderPlaintext',
        ];
    }
}