<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerT6GltLt\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerT6GltLt/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerT6GltLt.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerT6GltLt\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerT6GltLt\App_KernelDevDebugContainer([
    'container.build_hash' => 'T6GltLt',
    'container.build_id' => 'ce4cbaa4',
    'container.build_time' => 1678106355,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerT6GltLt');
