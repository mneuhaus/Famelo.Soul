<?php
namespace Famelo\Soul\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Soul".           *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Mvc\Routing\UriBuilder;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Security\Context;

/**
 * @Flow\Scope("singleton")
 */
class SoulRuntime {
	/**
	 * @var ActionRequest
	 */
	protected $currentRequest;

	/**
	 * @var UriBuilder
	 */
	protected $uriBuilder;

	public function injectCurrentRequest($request) {
		$this->currentRequest = $request;
		$this->uriBuilder = new UriBuilder();
		$this->uriBuilder->setRequest($this->currentRequest);
	}

	public function dispatch($soul) {
		var_dump('dispatch');
		var_dump($soul->getRootFragment());
		exit();
	}

	/**
	 * Redirects to another URI
	 *
	 * @param mixed $uri Either a string representation of a URI or a \TYPO3\Flow\Http\Uri object
	 * @throws \TYPO3\Flow\Mvc\Exception\StopActionException
	 * @api
	 */
	public function redirectToUri($uri) {
		header('Location: ' . (string) $uri);
		exit();
	}

	/**
	 * Redirects the request to another action and / or controller.
	 *
	 * Redirect will be sent to the client which then performs another request to the new URI.
	 *
	 * NOTE: This method only supports web requests and will throw an exception
	 * if used with other request types.
	 *
	 * @param string $actionName Name of the action to forward to
	 * @param string $controllerName Unqualified object name of the controller to forward to. If not specified, the current controller is used.
	 * @param string $packageKey Key of the package containing the controller to forward to. If not specified, the current package is assumed.
	 * @param array $arguments Array of arguments for the target action
	 * @param integer $delay (optional) The delay in seconds. Default is no delay.
	 * @param integer $statusCode (optional) The HTTP status code for the redirect. Default is "303 See Other"
	 * @param string $format The format to use for the redirect URI
	 * @return void
	 * @throws \TYPO3\Flow\Mvc\Exception\StopActionException
	 * @see forward()
	 * @api
	 */
	public function redirect($actionName, $controllerName = NULL, $packageKey = NULL, array $arguments = NULL, $delay = 0, $statusCode = 303, $format = NULL) {
		if ($packageKey !== NULL && strpos($packageKey, '\\') !== FALSE) {
			list($packageKey, $subpackageKey) = explode('\\', $packageKey, 2);
		} else {
			$subpackageKey = NULL;
		}
		$this->uriBuilder->reset();
		if ($format === NULL) {
			$this->uriBuilder->setFormat($this->currentRequest->getFormat());
		} else {
			$this->uriBuilder->setFormat($format);
		}

		$uri = $this->uriBuilder->setCreateAbsoluteUri(TRUE)->uriFor($actionName, $arguments, $controllerName, $packageKey, $subpackageKey);
		$this->redirectToUri($uri, $delay, $statusCode);
	}
}

?>