<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerYZKgsHS\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerYZKgsHS/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerYZKgsHS.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerYZKgsHS\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerYZKgsHS\App_KernelDevDebugContainer([
    'container.build_hash' => 'YZKgsHS',
    'container.build_id' => 'c632af1f',
    'container.build_time' => 1678705143,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerYZKgsHS');
