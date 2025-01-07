<?php

namespace SlackMessage;

class TextBlock
{
    /** @var array<mixed> $fields*/
    protected array $fields = [];

    public function text(string $content): self
    {
        $this->fields[] = [
            'type' => 'plain_text',
            'text' => $content,
            'emoji' => true
        ];

        return $this;
    }

    public function markdown(string $content): self
    {
        $this->fields[] = [
            'type' => 'mrkdwn',
            'text' => $content
        ];

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $block = ['type' => 'section'];

        if (!empty($this->fields)) {
            $block['fields'] = $this->fields;
        }

        return $block;
    }
}
