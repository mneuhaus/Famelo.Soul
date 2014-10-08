<?php
namespace Famelo\Soul\Domain\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Soul {
    /**
     * @var \Famelo\Soul\Domain\Model\AbstractFragment
     * @ORM\OneToOne(mappedBy="soul")
     */
    protected $rootFragment;

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
    }

    /**
     * Add to the fragments.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractFragment $piece
     */
    public function addFragment($piece) {
        $this->fragments->add($piece);
    }

    /**
     * Remove from pieces.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractFragment $piece
     */
    public function removeFragment($piece) {
        $this->pieces->remove($piece);
    }

    /**
     * Gets fragments.
     *
     * @return \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractFragment> $fragments
     */
    public function getFragments() {
        return $this->fragments;
    }

    /**
     * Sets the fragments.
     *
     * @param \Doctrine\Common\Collections\Collection<\Famelo\Soul\Domain\Model\AbstractFragment> $fragments
     */
    public function setFragments($fragments) {
        $this->fragments = $fragments;
    }

    /**
     * Gets rootFragment.
     *
     * @return \Famelo\Soul\Domain\Model\AbstractFragment $rootFragment
     */
    public function getRootFragment() {
        return $this->rootFragment;
    }

    /**
     * Sets the rootFragment.
     *
     * @param \Famelo\Soul\Domain\Model\AbstractFragment $rootFragment
     */
    public function setRootFragment($rootFragment) {
        $this->rootFragment = $rootFragment;
    }

}