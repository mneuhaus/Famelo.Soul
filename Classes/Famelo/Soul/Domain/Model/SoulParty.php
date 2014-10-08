<?php
namespace Famelo\Soul\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

trait SoulParty {

    /**
     * @var \Famelo\Soul\Domain\Model\Soul
     * @ORM\OneToOne(inversedBy="party")
     */
    protected $soul;

    /**
     * Gets soul.
     *
     * @return \Famelo\Saas\Domain\Model\Soul $soul
     */
    public function getSoul() {
        return $this->soul;
    }

    /**
     * Sets the soul.
     *
     * @param \Famelo\Saas\Domain\Model\Soul $soul
     */
    public function setSoul($soul){
        $this->soul = $soul;
    }

}

?>