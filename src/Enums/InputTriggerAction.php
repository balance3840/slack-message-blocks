<?php

namespace SlackMessage\Enums;

/**
 * Enum representing actions that trigger input events.
 */
enum InputTriggerAction: string
{
    case ON_CHARACTER_ENTERED = 'on_character_entered';
    case ON_ENTER_PRESSED = 'on_enter_pressed';
}
