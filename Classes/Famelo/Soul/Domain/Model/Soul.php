<?php
namespace Famelo\Soul\Domain\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Soul {

    const GRANT = 'grant';
    const ABSTAIN = 'abstain';
    const DENY = 'deny';
    const MOOT = 'moot';
    const BLOCK = 'block';

    /**
     * @var \Famelo\Soul\Domain\Model\AbstractSoulPiece
     * @ORM\OneToOne(mappedBy="pieces")
     */
    protected $rootPiece;

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece>
     * @ORM\OneToMany(mappedBy="soul")
     */
    protected $pieces;

    /**
     * @var string
     */
    protected $vote;

    /**
     * @var \TYPO3\Party\Domain\Model\AbstractParty
     * @ORM\OneToOne(mappedBy="soul")
     */
    protected $party;

    /**
    * TODO: Document this Method! ( __construct )
    */
    public function __construct() {
        $this->pieces = new ArrayCollection();
        $this->vote = self::ABSTAIN;
    }

    /**
     * Gets party.
     *
     * @return \TYPO3\Party\Domain\Model\AbstractParty $party
     */
    public function getParty() {
        return $this->party;
    }

    /**
     * Sets the party.
     *
     * @param \TYPO3\Party\Domain\Model\AbstractParty $party
     */
    public function setParty($party) {
        $this->party = $party;
    }

    /**
     * Add to the pieces.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractSoulPiece $piece
     */
    public function addPiece($piece) {
        $this->pieces->add($piece);
    }

    /**
     * Remove from pieces.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractSoulPiece $piece
     */
    public function removePiece($piece) {
        $this->pieces->remove($piece);
    }

    /**
     * Gets pieces.
     *
     * @return \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece> $pieces
     */
    public function getPieces() {
        return $this->pieces;
    }

    /**
     * Sets the pieces.
     *
     * @param \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece> $pieces
     */
    public function setPieces($pieces) {
        $this->pieces = $pieces;
    }

    /**
     * Gets rootPiece.
     *
     * @return \Famelo\Soul\Domain\Model\AbstractSoulPiece $rootPiece
     */
    public function getRootPiece() {
        return $this->rootPiece;
    }

    /**
     * Sets the rootPiece.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractSoulPiece $rootPiece
     */
    public function setRootPiece($rootPiece) {
        $this->rootPiece = $rootPiece;
    }

    /**
     * Gets vote.
     *
     * @return string $vote
     */
    public function getVote() {
        return $this->vote;
    }

    /**
     * Sets the vote.
     *
     * @param string $vote
     */
    public function setVote($vote) {
        $this->vote = $vote;
    }

    public function seekVotes($request) {
        $votes = $this->rootPiece->seekVotes($request);
        if (in_array(self::DENY, $votes)) {
            $this->vote = self::DENY;
        } else if (in_array(self::BLOCK, $votes)) {
            $this->vote = self::BLOCK;
        } else if (in_array(self::GRANT, $votes)) {
            $this->vote = self::GRANT;
        } else if (in_array(self::MOOT, $votes)) {
            $this->vote = self::MOOT;
        } else if (in_array(self::ABSTAIN, $votes)) {
            $this->vote = self::ABSTAIN;
        }
    }

}