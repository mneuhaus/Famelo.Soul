<?php
namespace Famelo\Soul\Core;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Reflection\ReflectionService;

/**
 * @Flow\Aspect
 */
class SoulTokenArgumentAttachmentAspect {
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;

    /**
     * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
     * @Flow\Before("method(TYPO3\Flow\Mvc\Routing\UriBuilder->uriFor())")
     * @return void
     */
    public function attachSoulToken(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
        if ($this->controllerImplementsFragmentInterface($joinPoint) === FALSE) {
            return;
        }

        $request = $joinPoint->getProxy()->getRequest();
        $controllerArguments = $joinPoint->getMethodArgument('controllerArguments');
        if ($request->getInternalArgument('__soulToken') !== NULL && isset($controllerArguments['__soulToken']) === FALSE) {
            $controllerArguments['__soulToken'] = $request->getInternalArgument('__soulToken');
            $joinPoint->setMethodArgument('controllerArguments', $controllerArguments);
        }
    }

    public function controllerImplementsFragmentInterface($joinPoint) {
        $request = $joinPoint->getProxy()->getRequest();

        if (!$request instanceof ActionRequest) {
            return FALSE;
        }

        $controllerName = $joinPoint->getMethodArgument('controllerName');
        if ($controllerName === NULL) {
            $controllerName = $request->getControllerName();
        }

        $packageKey = $joinPoint->getMethodArgument('packageKey');
        if ($packageKey === NULL) {
            $packageKey = $request->getControllerPackageKey();
        }

        $subPackageKey = $joinPoint->getMethodArgument('subPackageKey');
        if ($subPackageKey === NULL) {
            $subPackageKey = $request->getControllerSubPackageKey();
        }

        $possibleObjectName = '\@package\@subpackage\Controller\@controllerController';
        $possibleObjectName = str_replace('@package', str_replace('.', '\\', $packageKey), $possibleObjectName);
        $possibleObjectName = str_replace('@subpackage', $subPackageKey, $possibleObjectName);
        $possibleObjectName = str_replace('@controller', $controllerName, $possibleObjectName);
        $possibleObjectName = str_replace('\\\\', '\\', $possibleObjectName);

        $controllerObjectName = $this->objectManager->getCaseSensitiveObjectName($possibleObjectName);

        return $this->reflectionService->isClassImplementationOf($controllerObjectName, 'Famelo\Soul\Core\FragmentInterface') || property_exists($controllerObjectName, 'soulControllerTrait');
    }

}