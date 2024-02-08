<?php
/**
 * Copyright © ...
 */

namespace Customer\Controller;

use Api\SessionInterface;
use Customer\Api\ValidationInterface;

/**
 * Delete customer
 */
class Delete extends Action
{
    public function execute(): array
    {
        if (isset($_SERVER[self::HTTP_X_REQUESTED_WITH]) &&
            strtolower($_SERVER[self::HTTP_X_REQUESTED_WITH]) == self::XML_HTTP_REQUEST
        ) {
            return $this->process();
        }

        return $this->response('error', 'Something went wrong...');
    }

    protected function process(): array
    {
        try {
            if (!$this->validation->isIdParamValid()) {
                return $this->response('error', 'Data not Correct...');
            }

            $params = $this->validation->getParams();
            $this->request->delete($params);
            $_SESSION[SessionInterface::KEY_MSG] = 'Customer: ' . $params[ValidationInterface::PARAM_USERNAME] . ' was successfully removed';

            return $this->response('success', 'Removed...');
        } catch (\Exception $ex) {
            $this->message->log($ex->getMessage());

            return $this->response('error', 'Something went wrong...');
        }
    }
}
