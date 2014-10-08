<?php
namespace Famelo\Soul\Domain\Listener;

use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\ObjectManager;
use Famelo\Soul\Domain\Model\Soul;
use Famelo\Soul\Domain\Model\SoulPartyInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Flow\Reflection\ObjectAccess;
use TYPO3\Flow\Reflection\ReflectionService;
use TYPO3\Flow\Security\Context;
use TYPO3\Flow\Utility\PositionalArraySorter;

class SoulListener implements EventSubscriber {

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;

    /**
     * @Flow\Inject
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents() {
        return array(
            'onFlush'
        );
    }

    /**
     * If it's a SoftDeleteable object, update the "deletedAt" field
     * and skip the removal of the object
     *
     * @param EventArgs $args
     * @return void
     */
    public function onFlush(EventArgs $args) {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        $soulMetadata = $entityManager->getClassMetadata('Famelo\Soul\Domain\Model\Soul');

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $className = get_class($entity);
            if (!$entity instanceof SoulPartyInterface) {
                continue;
            }

            $soulPieces = $this->getSoulPieces($className);

            $soul = new Soul();
            $soul->setParty($entity);
            $previousPiece = NULL;
            foreach ($soulPieces as $pieceName => $soulPiece) {
                $nextPieces = array();

                $piece = new $soulPiece['className']($soulPiece);
                $soul->addPiece($piece);
                $nextPiece = $piece;

                if ($previousPiece === NULL) {
                    $soul->setRootPiece($piece);
                } else {
                    $previousPiece->addChild($piece);
                    $previousPiece = $nextPiece;
                }

                $pieceMetadata = $entityManager->getClassMetadata($soulPiece['className']);
                $entityManager->persist($piece);
                $unitOfWork->computeChangeSet($pieceMetadata, $piece);
            }

            $entityManager->persist($soul);
            $unitOfWork->computeChangeSet($soulMetadata, $soul);
            ObjectAccess::setProperty($entity, 'soul', $soul);
            $unitOfWork->propertyChanged($entity, 'soul', NULL, $soul);
        }
    }

    public function getSoulPieces($className) {
        $soulPieces = $this->configurationManager->getConfiguration('Souls', '\\' . ltrim($className, '\\'));
        $sorter = new PositionalArraySorter($soulPieces);
        return $sorter->toArray();
    }

}
