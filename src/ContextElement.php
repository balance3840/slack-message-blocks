<?php

namespace SlackMessage;

class ContextElement
{

    /** @var array<mixed> $elements */
    protected array $elements = [];

    public function text(string $content): self
    {
        $this->elements[] = [
            'type' => 'plain_text',
            'text' => $content,
            'emoji' => true
        ];

        return $this;
    }

    public function markdown(string $content): self
    {
        $this->elements[] = [
            'type' => 'mrkdwn',
            'text' => $content
        ];

        return $this;
    }

    public function image(string $url, string $altText): self
    {
        $this->elements[] = [
            'type' => 'image',
            'image_url' => $url,
            'alt_text' => $altText
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
