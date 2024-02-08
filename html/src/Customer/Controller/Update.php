<?php
/**
 * Copyright © ...
 */

namespace Customer\Controller;

use Api\SessionInterface;
use Customer\Api\ValidationInterface;

/**
 * Update customer
 */
class Update extends Action
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
            if (!$this->validation->isPostParamsExistsForUpdateAction() || !$this->validation->isUsernameAndIdValid()) {
                return $this->response('error', 'Data not Correct...');
            }

            $params = $this->validation->getParams();
            $id = $params[ValidationInterface::PARAM_ID];
            $username = $params[ValidationInterface::PARAM_USERNAME];

            if ($this->isCustomerExist($id, $username)) {
                return $this->response('error', 'Customer with same Username already exists');
            }

            if (!$this->isDataUpdated($id)) {
                return $this->response('error', 'Nothing was changed');
            }

            $this->request->update($params);
            $_SESSION[SessionInterface::KEY_MSG] = 'Customer: ' . $params[ValidationInterface::PARAM_USERNAME] . ' was successfully updated';

            return $this->response('success', 'Updated...');
        } catch (\Exception $ex) {
            $this->message->log($ex->getMessage());

            return $this->response('error', 'Something went wrong...');
        }
    }

    private function isCustomerExist(string $id, string $username): bool
    {
        $customerById = $this->request->getCustomerById($id);
        $customerByUsername = $this->request->getCustomerByUsername($username);

        return $customerByUsername &&
            $customerById[ValidationInterface::PARAM_USERNAME] != $customerByUsername[ValidationInterface::PARAM_USERNAME];
    }

    private function isDataUpdated(string $id): bool
    {
        return $this->validation->isDataChanged($this->request->getCustomerById($id));
    }
}
