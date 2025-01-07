<?php

namespace SlackMessage;

class CheckboxOption extends SelectOption
{
    public function option(
        string $display,
        string $value,
        ?string $description = null
    ): self {
        $option = [
            'text' => [
                'type' => 'mrkdwn',
                'text' => $display
            ],
            'value' => $value
        ];

        if ($description) {
            $option['description'] = [
                'type' => 'mrkdwn',
                'text' => $description
            ];
        }

        $this->options[] = $option;

        return $this;
    }
}
