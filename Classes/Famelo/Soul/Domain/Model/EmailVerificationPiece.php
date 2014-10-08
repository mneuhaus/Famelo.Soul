<?php
namespace Famelo\Soul\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class EmailVerificationPiece extends AbstractSoulPiece {

	public function indexAction($request) {
		$this->vote = self::BLOCK;
	}

	// public function getLabel() {
	// 	return 'Email verification';
	// }

	// public function handle() {
	// 	$message = new ClientAwareMessage();
	// 	$message->setTemplate('EmailVerification');
	// 	$message->setTo(array($this->getUser()->getContact()->getEmail() => $this->getUser()->getContact()->__toString()));
	// 	$message->assign('token', $this->token);
	// 	$message->send();
	// 	$this->vote = self::DENY;
	// 	$this->addFlashMessage('An E-Mail has been sent to your E-Mail address. Please check your emails and click on the confirm link contained in that email.');
	// }

 //    /**
 //     * @param ActionRequest $request
 //     */
 //    public function handleTokenRequest($request) {
 //        $this->vote = self::GRANT;
 //        $this->addFlashMessage('Thank you for verifiying your E-Mail');
 //    }
}