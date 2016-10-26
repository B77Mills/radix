<?php

namespace AppBundle\Integration\Handler;

use AppBundle\Integration\Definition\ExternalIdentityDefinition;

interface IdentifyInterface extends HandlerInterface
{
    /**
     * Executes the the identify integration.
     *
     * @param   string  $externalId
     * @return  ExternalIdentityDefinition
     * @throws  \Exception  On any internal identification error.
     */
    public function execute($externalId);

    /**
     * Gets the external identity source and identifier that will be used for upserting the identity.
     * Returns a tuple of source and identifier.
     * If an error occurs during the retrieval process (identity not found, third-party server errors, etc), should throw an exception.
     *
     * @param   string  $externalId
     * @return  array
     * @throws  \Exception  On a retrieval error.
     */
    public function getSourceAndIdentifierFor($externalId);

    /**
     * Gets the identity source that wll be used for locating related external identities.
     *
     * @return  string
     */
    public function getSourceKey();
}
