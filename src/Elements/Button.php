<?php

namespace SlackMessage\Elements;

use SlackMessage\Enums\ButtonStyle;

class Button
{
    /** @var array<mixed> $button */
    protected array $button = [
        'type' => 'button'
    ];

    public function text(string $text): self
    {
        $this->button['text'] = [
            'type' => 'plain_text',
            'text' => $text,
            'emoji' => true
        ];

        return $this;
    }

    public function value(string $value): self
    {
        $this->button['value'] = $value;

        return $this;
    }

    public function style(
        ButtonStyle $style
    ): self {
        $this->button['style'] = $style->value;

        return $this;
    }


    public function actionId(string $actionId): self
    {
        $this->button['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->button;
    }
}
