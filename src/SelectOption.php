<?php

namespace SlackMessage;

class SelectOption
{
    /** @var array<mixed> $options*/
    protected array $options = [];

    public function option(string $display, string $value): self
    {
        $this->options[] = [
            'text' => [
                'type' => 'plain_text',
                'text' => $display,
                'emoji' => true
            ],
            'value' => $value
        ];

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
