<?php
namespace Famelo\Soul\Domain\Model;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Famelo\Soul\Domain\Model\Soul;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Algorithms;

/**
 * @Flow\Entity
 * @ORM\InheritanceType("JOINED")
 */
class AbstractFragment {
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Soul
     * @ORM\ManyToOne(inversedBy="fragments")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $soul;

    /**
    * TODO: Document this Method! ( __construct )
    */
    public function __construct($name = NULL) {
        $this->name = $name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param Soul $soul
     */
    public function setSoul($soul) {
        $this->soul = $soul;
    }

    /**
     * @return Soul
     */
    public function getSoul() {
        return $this->soul;
    }
}