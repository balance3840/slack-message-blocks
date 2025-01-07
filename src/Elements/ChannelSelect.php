<?php

namespace SlackMessage\Elements;

class ChannelSelect
{
    /**
     * @var array<mixed> $channelSelect
     */
    protected array $channelSelect = [
        'type' => 'channels_select'
    ];

    public function placeholder(string $placeholder): self
    {
        $this->channelSelect['placeholder'] = [
            'type' => 'plain_text',
            'text' => $placeholder,
            'emoji' => true
        ];

        return $this;
    }

    public function actionId(string $actionId): self
    {
        $this->channelSelect['action_id'] = $actionId;

        return $this;
    }

    public function initialChannel(string $initialChannel): self
    {
        $this->channelSelect['initial_channel'] = $initialChannel;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->channelSelect;
    }
}
