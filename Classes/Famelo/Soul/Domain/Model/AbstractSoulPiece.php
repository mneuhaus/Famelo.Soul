<?php
namespace Famelo\Soul\Domain\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Utility\Algorithms;

/**
 * @Flow\Entity
 * @ORM\InheritanceType("JOINED")
 */
abstract class AbstractSoulPiece {

    const GRANT = 'grant';
    const ABSTAIN = 'abstain';
    const DENY = 'deny';
    const MOOT = 'moot';
    const BLOCK = 'block';

    /**
     * @Flow\Transient
     * @var string
     */
    protected $reminderInterval = '7 days';

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece>
     * @ORM\ManyToMany(inversedBy="")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(name="child_inverse_id")})
     */
    protected $children;

    /**
     * @var string
     */
    protected $vote;

    /**
     * @var \Famelo\Soul\Domain\Model\Soul
     * @ORM\ManyToOne(inversedBy="pieces")
     */
    protected $soul;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $status;

    /**
     * TODO: Document this Method! ( __construct )
     */
    public function __construct() {
        $this->children = new ArrayCollection();
        $this->vote = self::ABSTAIN;
        $this->token = str_replace('-', '', Algorithms::generateUuid());
    }

    /**
     * Add to the children.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractSoulPiece $child
     */
    public function addChild($child) {
        $this->children->add($child);
    }

    /**
     * Remove from children.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractSoulPiece $child
     */
    public function removeChild($child) {
        $this->children->remove($child);
    }

    /**
     * Gets children.
     *
     * @return \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece> $children
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Sets the children.
     *
     * @param \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece> $children
     */
    public function setChildren($children) {
        $this->children = $children;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents() {

    }

    /**
     * TODO: Document this Method! ( removeReminder )
     */
    public function removeReminder() {
        $this->nextReminder = NULL;
    }

    /**
     * Gets soul.
     *
     * @return \Famelo\Soul\Domain\Model\Soul $soul
     */
    public function getSoul() {
        return $this->soul;
    }

    /**
     * Sets the soul.
     *
     * @param \Famelo\Soul\Domain\Model\Soul $soul
     */
    public function setSoul($soul) {
        $this->soul = $soul;
    }

    /**
     * Gets status.
     *
     * @return string $status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Sets the status.
     *
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Gets token.
     *
     * @return string $token
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Sets the token.
     *
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * TODO: Document this Method! ( getUser )
     */
    public function getUser() {
        return $this->getChain()->getUser();
    }

    /**
     * TODO: Document this Method! ( getVoteClass )
     */
    public function getVoteClass() {
        $classes = array(
            'grant' => 'success',
        	'abstain' => 'info',
        	'deny' => 'danger'
        );
        return $classes[$this->vote];
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

    // /**
    //  * TODO: Document this Method! ( addReminder )
    //  */
    // public function addReminder() {
    //     if ($this->nextReminder === NULL) {
    //         $this->nextReminder = new \DateTime();
    //         $this->nextReminder->modify($this->getChain()->getUser()->getBranch()->getGracePeriod());
    //     } else {
    //         $nextReminder = clone $this->nextReminder->modify($this->reminderInterval);
    //         $this->nextReminder = $nextReminder;
    //     }
    // }

    /**
     * TODO: Document this Method! ( isComplete )
     */
    public function seekVotes($request, $votes = array()) {
        if ($this->vote === self::ABSTAIN) {
            $this->indexAction($request);
        }
        $votes[] = $this->vote;

        if ($this->vote !== self::BLOCK) {
            foreach ($this->children as $child) {
                $child->seekVotes($request, $votes);
            }
        }

        return $votes;
    }

}