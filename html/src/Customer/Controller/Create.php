<?php
/**
 * Copyright © ...
 */

namespace Customer\Controller;

use Api\SessionInterface;
use Customer\Api\ValidationInterface;

/**
 * Create customer
 */
class Create extends Action
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
            if (!$this->validation->isPostParamsExistsForCreateAction()) {
                return $this->response('error', 'Data not Correct...');
            }

            $params= $this->validation->getParams();

            if ($this->request->getCustomerByUsername($params[ValidationInterface::PARAM_USERNAME])) {
                return $this->response('error', 'Customer with same Username already exists.');
            }

            $this->request->create($this->validation->getParams());
            $_SESSION[SessionInterface::KEY_MSG] = 'Customer: ' . $params[ValidationInterface::PARAM_USERNAME] . ' was successfully created';

            return $this->response('success', 'Created');
        } catch (\Exception $ex) {
            $this->message->log($ex->getMessage());

            return $this->response('error', 'Something went wrong...');
        }
    }
}
