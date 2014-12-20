<?php
namespace Famelo\Soul\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Harvest".        *
 *                                                                        *
 *                                                                        */

use Famelo\Soul\Domain\Model\PartySoul;
use Famelo\Soul\Service\SoulRuntime;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;

/**
 * Standard controller for the Brain package
 */
class SoulController extends AbstractSoulController {

	/**
	 * @Flow\Inject
	 * @var ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @Flow\Inject
	 * @var SoulRuntime
	 */
	protected $soulRuntime;

	/**
	 * @param string $soul
	 */
	public function indexAction($soul) {
		$soul = new PartySoul();

		$souls = $this->configurationManager->getConfiguration('Souls');
		$soulDefinition = $souls['InviteRequest'];

        $previousFragments = array();
        foreach ($soulDefinition['fragments'] as $fragmentNames) {
        	if (!is_array($fragmentNames)) {
        		$fragmentNames = array($fragmentNames);
        	}
            $nextFragments = array();
            foreach ($fragmentNames as $fragmentName) {
            	$fragmentDefinition = $fragmentDefinitions[$fragmentName];
            	$fragmentClassName = isset($fragmentDefinition['fragment']) ? $fragmentDefinition['fragment'] : '\Famelo\Soul\Domain\Model\Fragment';

            	$fragment = new $fragmentClassName($fragmentDefinition);
            	$soul->addFragment($fragment);
            	$nextFragments = $fragment;

                if ($soul->getRootFragment() === NULL) {
                    $soul->setRootFragment($fragment);
                }

                foreach ($previousFragments as $previousFragment) {
                    $previousFragment->addChild($fragment);
                }
            }
            if (!empty($nextFragments)) {
                $previousFragments = $nextFragments;
            }
        }

		$this->persistenceManager->add($soul);
		$this->persistenceManager->persistAll();

		$this->soulRuntime->dispatch($soul);
	}
}

?>
