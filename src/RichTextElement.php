<?php

namespace SlackMessage;

use SlackMessage\Enums\ListStyle;

class RichTextElement
{
    /** @var array<mixed> $elements*/
    protected array $elements = [];

    /*
        * @param array<RichTextSectionElement> $elements
    */
    public function section(callable $callback): self
    {
        $richTextSectionElement = new RichTextSectionElement;
        $callback($richTextSectionElement);
        $this->elements[] = [
            'type' => 'rich_text_section',
            'elements' => $richTextSectionElement->toArray()
        ];

        return $this;
    }

    public function list(callable $callback, ?ListStyle $style = ListStyle::BULLET, ?int $indent = 0): self
    {
        $richTextElement = new self;
        $callback($richTextElement);
        $this->elements[] = [
            'type' => 'rich_text_list',
            'style' => $style->value,
            'indent' => $indent,
            'elements' => $richTextElement->toArray()
        ];

        return $this;
    }

    public function preformated(callable $callback): self
    {
        $richTextSectionElement = new RichTextSectionElement;
        $callback($richTextSectionElement);
        $this->elements[] = [
            'type' => 'rich_text_preformatted',
            'elements' => $richTextSectionElement->toArray()
        ];

        return $this;
    }

    public function quote(callable $callback): self
    {
        $richTextSectionElement = new RichTextSectionElement;
        $callback($richTextSectionElement);
        $this->elements[] = [
            'type' => 'rich_text_quote',
            'elements' => $richTextSectionElement->toArray()
        ];

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->elements;
    }
}
