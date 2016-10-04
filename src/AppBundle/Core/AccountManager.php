<?php

namespace AppBundle\Core;

use As3\Modlr\Models\Model;
use Symfony\Component\HttpFoundation\Request;

class AccountManager
{
    const PUBLIC_KEY_PARAM = 'x-radix-appid';
    const USING_PARAM      = 'X-Radix-Using';
    const ENV_KEY          = 'APP';
    const APP_PATH         = '/app';

    /**
     * @var Model|null
     */
    private $account;

    /**
     * @var bool
     */
    private $allowDbOps = true;

    /**
     * @var Model|null
     */
    private $application;

    /**
     * Sets whether database operations are allowed.
     *
     * @param   bool    $bit
     * @return  self
     */
    public function allowDbOperations($bit = true)
    {
        $this->allowDbOps = (boolean) $bit;
        return $this;
    }

    /**
     * Determines the request context: one of application or core.
     *
     * @param   Request $request
     * @return  string
     */
    public function extractContextFrom(Request $request)
    {
        return 0 === stripos($request->getPathInfo(), self::APP_PATH) ? 'application' : 'core';
    }

    /**
     * Extracts the application public key from the Request.
     *
     * @param   Request $request
     * @return  string|null
     */
    public function extractPublicKeyFrom(Request $request)
    {
        $param   = self::PUBLIC_KEY_PARAM;
        $values  = [
            'header' => $request->headers->get($param),
            'query'  => $request->query->get($param),
        ];

        $publicKey = null;
        foreach ($values as $value) {
            if (!empty($value)) {
                $publicKey = $value;
                break;
            }
        }
        return empty($publicKey) ? null : $publicKey;
    }

    /**
     * @return  Model|null
     */
    public function getApplication()
    {
        return $this->application;
    }


    /**
     * @return  string|null
     */
    public function getCompositeKey()
    {
        if (false === $this->hasApplication()) {
            return;
        }
        return sprintf('%s:%s', $this->account->get('key'), $this->application->get('key'));
    }

    /**
     * @return  string|null
     */
    public function getDatabaseSuffix()
    {
        if (false === $this->hasApplication()) {
            return;
        }
        return sprintf('%s-%s', $this->account->get('key'), $this->application->get('key'));
    }

    /**
     * @return  bool
     */
    public function hasApplication()
    {
        return null !== $this->application;
    }

    /**
     * @param   Model   $application
     * @return  self
     */
    public function setApplication(Model $application)
    {
        $this->application = $application;
        $this->account     = $application->get('account');
        return $this;
    }

    /**
     * Deteremines whether database operations are allowed.
     *
     * @return  bool
     */
    public function shouldAllowDbOperations()
    {
        if (true === $this->allowDbOps) {
            return true;
        }
        return $this->hasApplication();
    }
}
