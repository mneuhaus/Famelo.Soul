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

    // const GRANT = 'grant';
    // const ABSTAIN = 'abstain';
    // const DENY = 'deny';
    // const MOOT = 'moot';
    // const BLOCK = 'block';

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractSoulPiece>
     * @ORM\ManyToMany(inversedBy="")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(name="child_inverse_id")})
     */
    protected $children;

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
     * TODO: Document this Method! ( __construct )
     */
    public function __construct() {
        $this->children = new ArrayCollection();
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

}