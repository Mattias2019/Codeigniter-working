<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Plasticbrain\FlashMessages\FlashMessages;

/**
 * https://github.com/plasticbrain/PhpFlashMessages
 */
class Notify
{
    // Message types and shortcuts
    const SUCCESS = 's';
    const ERROR = 'e';

    public function __construct()
    {
    }

    public function set($mess, $type = FlashMessages::SUCCESS)
    {
        $msg = new FlashMessages();

        if ($type == self::ERROR) {
            $msg->error($mess);
        } elseif ($type == self::SUCCESS) {
            $msg->success($mess);
        }

        return;
    }

}
