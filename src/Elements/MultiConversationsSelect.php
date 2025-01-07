<?php

namespace SlackMessage\Elements;

class MultiConversationsSelect
{
    /**
     * @var array<mixed> $multiConversationsSelect
     */
    protected array $multiConversationsSelect = [
        'type' => 'multi_conversations_select'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->multiConversationsSelect['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->multiConversationsSelect['action_id'] = $actionId;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->multiConversationsSelect;
    }
}
