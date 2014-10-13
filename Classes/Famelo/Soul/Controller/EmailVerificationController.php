<?php
namespace Famelo\Soul\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Harvest".        *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Brain package
 */
class EmailVerificationController extends AbstractSoulController {
	/**
	 * @var string
	 */
	protected $fragmentIdentifier = 'EmailVerification';

	public function indexAction() {

	}

	public function verifyAction() {
		$this->soul->setEmailVerified(true);
		$this->done();
	}
}

?>
