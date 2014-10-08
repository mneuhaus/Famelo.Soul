<?php
namespace Famelo\Soul\Service;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;

class SoulService {
    /**
     * @Flow\inject
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var ActionRequest
     */
    protected $currentRequest;

    public function injectCurrentRequest($request) {
        $this->currentRequest = $request;
    }

    public function checkPieces($party) {
        $soul = $party->getSoul();
        $soul->seekVotes($this->currentRequest);
        $this->persistenceManager->update($soul);
    }

    public function dispatch($party) {
        $soul = $party->getSoul();
        $output = $soul->dispatch($this->currentRequest);
        $this->persistenceManager->update($soul);
        return $output;
    }
}

?>