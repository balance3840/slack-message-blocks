<?php

namespace SlackMessage\Elements;

class ConversationSelect
{
    /**
     * @var array<mixed> $conversationSelect
     */
    protected array $conversationSelect = [
        'type' => 'conversations_select'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->conversationSelect['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->conversationSelect['action_id'] = $actionId;

        return $this;
    }

    public function initialConversation(string $initialConversation): self
    {
        $this->conversationSelect['initial_conversation'] = $initialConversation;

        return $this;
    }

    /**
     * @param array<string> $include
     * @param bool $excludeBotUsers
     * @param bool $excludeExternalSharedChannels
     * @return self
     */
    public function filter(
        array $include = [],
        bool $excludeBotUsers = false,
        bool $excludeExternalSharedChannels = false
    ): self
    {
        if (!empty($include)) {
            $this->conversationSelect['filter']['include'] = $include;
        }

        if ($excludeBotUsers) {
            $this->conversationSelect['filter']['exclude_bot_users'] = true;
        }

        if ($excludeExternalSharedChannels) {
            $this->conversationSelect['filter']['exclude_external_shared_channels'] = true;
        }

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->conversationSelect;
    }
}
