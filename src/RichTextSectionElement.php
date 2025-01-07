<?php

namespace SlackMessage;

class RichTextSectionElement
{
     /**
     * @var array<mixed> $richTextSectionElements
     */
    protected array $richTextSectionElements = [];

    public function text(
        string $text,
        ?bool $bold = false,
        ?bool $italic = false,
        ?bool $strike = false
    ): self {
        $richTextElement = [
            'type' => 'text',
            'text' => $text,
            'style' => [
                'bold' => $bold,
                'italic' => $italic,
                'strike' => $strike
            ]
        ];

        $this->richTextSectionElements[] = $richTextElement;

        return $this;
    }

    public function link(
        string $text,
        string $url,
        ?bool $bold = false,
        ?bool $italic = false,
        ?bool $strike = false
    ): self {
        $richTextElement = [
            'type' => 'link',
            'url' => $url,
            'text' => $text,
            'style' => [
                'bold' => $bold,
                'italic' => $italic,
                'strike' => $strike
            ]
        ];

        $this->richTextSectionElements[] = $richTextElement;

        return $this;
    }

    public function emoji(string $emoji): self
    {
        $richTextElement = [
            'type' => 'emoji',
            'name' => $emoji
        ];

        $this->richTextSectionElements[] = $richTextElement;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->richTextSectionElements;
    }

}
