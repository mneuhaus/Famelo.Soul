<?php
namespace Famelo\Soul\Domain\Model;

interface SoulPartyInterface {
    /**
     * Gets soul.
     *
     * @return \Famelo\Saas\Domain\Model\Soul $soul
     */
    public function getSoul();

    /**
     * Sets the soul.
     *
     * @param \Famelo\Saas\Domain\Model\Soul $soul
     */
    public function setSoul($soul);
}

?>