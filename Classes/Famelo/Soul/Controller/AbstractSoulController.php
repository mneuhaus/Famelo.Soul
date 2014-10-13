<?php
namespace Famelo\Soul\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Harvest".        *
 *                                                                        *
 *                                                                        */

use Famelo\Soul\Core\FragmentInterface;
use Famelo\Soul\Domain\Model\Soul;
use Famelo\Soul\Domain\Repository\SoulRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;

/**
 * Standard controller for the Brain package
 */
abstract class AbstractSoulController extends \TYPO3\Flow\Mvc\Controller\ActionController implements FragmentInterface{
	/**
	 * @Flow\Inject
	 * @var ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @var Soul
	 */
	protected $soul;

	/**
	 * @Flow\inject
	 * @var SoulRepository
	 */
	protected $soulRepository;

	/**
	 * Handles a request. The result output is returned by altering the given response.
	 *
	 * @param \TYPO3\Flow\Mvc\RequestInterface $request The request object
	 * @param \TYPO3\Flow\Mvc\ResponseInterface $response The response, modified by this handler
	 * @return void
	 * @throws \TYPO3\Flow\Mvc\Exception\UnsupportedRequestTypeException
	 * @api
	 */
	public function processRequest(\TYPO3\Flow\Mvc\RequestInterface $request, \TYPO3\Flow\Mvc\ResponseInterface $response) {
		$soulToken = $request->getInternalArgument('__soulToken');
		if ($soulToken !== NULL) {
			$this->soul = $this->soulRepository->findOneByToken($soulToken);
		}

		$soulName = $request->getInternalArgument('__soul');
		if ($soulName !== NULL) {
			$this->soul = $this->createSoul($soulName);
			$this->persistenceManager->add($this->soul);
			$this->persistenceManager->whitelistObject($this->soul);
			$this->persistenceManager->persistAll(TRUE);
			$request->setArgument('__soulToken', $this->soul->getToken());
		}

		$fragmentDefinitions = $this->configurationManager->getConfiguration('Fragments');
		$this->fragmentDefinition = $fragmentDefinitions[$this->getFragmentIdentifier()];

		parent::processRequest($request, $response);

		$this->persistenceManager->update($this->soul);
		$this->persistenceManager->whitelistObject($this->soul);
		$this->persistenceManager->persistAll(TRUE);
	}

	public function createSoul($soulName) {
		$souls = $this->configurationManager->getConfiguration('Souls');
		$soulDefinition = $souls[$soulName];

		if (isset($soulDefinition['soul'])) {
			$soul = new $soulDefinition['soul']();
		} else {
			$soul = new Soul();
		}
		$soul->setIdentifier($soulName);
		return $soul;
	}

	public function getFragmentIdentifier() {
		return $this->fragmentIdentifier;
	}

	public function done() {
		$this->persistenceManager->update($this->soul);
		$this->persistenceManager->whitelistObject($this->soul);
		$this->persistenceManager->persistAll(TRUE);

		$souls = $this->configurationManager->getConfiguration('Souls');
		$fragmentDefinitions = $this->configurationManager->getConfiguration('Fragments');
		$soulDefinition = $souls[$this->soul->getIdentifier()];
		$fragmentTransitions = $soulDefinition['fragments'][$this->getFragmentIdentifier()];
		foreach ($fragmentTransitions as $fragmentName => $condition) {
			$fragmentDefinition = $fragmentDefinitions[$fragmentName];
			# todo: implement condition
			if (isset($fragmentDefinition['controller'])) {
				$request = clone $this->request;
				$request->setControllerObjectName($fragmentDefinition['controller']);
				$request->setControllerActionName($fragmentDefinition['action']);
				$this->redirectToRequest($request);
			}
		}
	}
}

?>
