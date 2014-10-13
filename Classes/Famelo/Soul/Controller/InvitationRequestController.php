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
class InvitationRequestController extends AbstractSoulController {
	/**
	 * @var string
	 */
	protected $fragmentIdentifier = 'InvitationRequest';

	public function indexAction() {
	}


	/**
	 * @param string $email
	 */
	public function requestInviteAction($email) {
		$this->soul->setEmail($email);
		$this->done();
	}
}

?>
