<?php
namespace Famelo\Soul\Core;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Flow\Http\Component\ComponentContext;
use TYPO3\Flow\Http\Component\ComponentInterface;
use TYPO3\Flow\Http\Component\Exception as ComponentException;
use TYPO3\Flow\Object\ObjectManagerInterface;
use TYPO3\Flow\Utility\Algorithms;

/**
 * A routing HTTP component
 */
class SoulRoutingComponent implements ComponentInterface {

	/**
	 * @Flow\Inject
	 * @var ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array()) {
		$this->options = $options;
	}

	/**
	 * Resolve a route for the request
	 *
	 * Stores the resolved route values in the ComponentContext to pass them
	 * to other components. They can be accessed via ComponentContext::getParameter('TYPO3\Flow\Mvc\Routing\RoutingComponent', 'matchResults');
	 *
	 * @param ComponentContext $componentContext
	 * @return void
	 */
	public function handle(ComponentContext $componentContext) {
		$matchResults = $componentContext->getParameter('TYPO3\Flow\Mvc\Routing\RoutingComponent', 'matchResults');
		// var_dump($matchResults);

		$fragment = 'InvitationRequest';
		for ($i=0; $i < 10; $i++) {
			$soulToken = str_replace('-', '', Algorithms::generateUuid());
			$soulHash = substr($soulToken, 6, 6);
			$fragmentHash = substr(sha1($fragment . $soulHash . 'secret'), 6, 6);
			// var_dump($soulToken, $soulHash . '-' . $fragmentHash);
		}
	}

}