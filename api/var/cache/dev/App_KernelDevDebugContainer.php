<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerDNj7K9k\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerDNj7K9k/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerDNj7K9k.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerDNj7K9k\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerDNj7K9k\App_KernelDevDebugContainer([
    'container.build_hash' => 'DNj7K9k',
    'container.build_id' => 'd5fcd0c3',
    'container.build_time' => 1683726346,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerDNj7K9k');
