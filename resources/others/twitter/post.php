<?php

require_once ('codebird.php');
\Codebird\Codebird::setConsumerKey('oyptgFh88tVBmhXBSywcoeImQ', 'sFhwc99LjYbDxdvHZQfUPscQv6pqiP35kdAdldIclgybS5imKJ'); // static, see 'Using multiple Codebird instances'

$cb = \Codebird\Codebird::getInstance();

$cb->setToken('310088233-nlHAOtTbQVKBZq1CsUmMpjSekI1zvsbtBcgTlOnw', 'qsb8XFDBvL7bmQ1X006iMU7gmLw6EE7fr4nJODzYGnDLr');

$reply = $cb->oauth2_token();
if (isset($reply->errors)) {
    echo $reply->errors[0]->message;
} else {
    $bearer_token = $reply->access_token;
    \Codebird\Codebird::setBearerToken($bearer_token);
    $params = array(
        'status' => 'Fish & chips woooh'
    );
    $reply = $cb->statuses_update($params);
}



