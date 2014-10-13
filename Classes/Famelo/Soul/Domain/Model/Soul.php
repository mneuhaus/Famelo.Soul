<?php
namespace Famelo\Soul\Domain\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Famelo\Soul\Domain\Model\AbstractFragment;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Algorithms;

/**
 * @Flow\Entity
 * @ORM\InheritanceType("JOINED")
 */
class Soul {

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractFragment>
     * @ORM\OneToMany(mappedBy="soul")
     */
    protected $fragments;

    /**
    * TODO: Document this Method! ( __construct )
    */
    public function __construct() {
        $this->fragments = new ArrayCollection();
        $this->token = str_replace('-', '', Algorithms::generateUuid());
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
     * @param string $identifier
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

        /**
     * Add to the fragments.
     *
     * @param AbstractFragment $fragment
     */
    public function addFragment($fragment) {
        $fragment->setSoul($this);
        $this->fragments->add($fragment);
    }

    /**
     * Remove from fragments.
     *
     * @param AbstractFragment $fragment
     */
    public function removeFragment($fragment) {
        $this->fragments->remove($fragment);
    }

    /**
     * Gets fragments.
     *
     * @return \Doctrine\Common\Collections\Collection<AbstractFragment> $fragments
     */
    public function getFragments() {
        return $this->fragments;
    }

    /**
     * Sets the fragments.
     *
     * @param \Doctrine\Common\Collections\Collection<AbstractFragment> $fragments
     */
    public function setFragments($fragments) {
        $this->fragments = $fragments;
    }

    public function hasFragment($fragmentName) {
        foreach ($this->fragments as $fragment) {
            if ($fragment->getName() == $fragmentName) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getFragment($fragmentName) {
        foreach ($this->fragments as $fragment) {
            if ($fragment->getName() == $fragmentName) {
                return $fragment;
            }
        }
    }

}