<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container3uc018A\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container3uc018A/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container3uc018A.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container3uc018A\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container3uc018A\App_KernelDevDebugContainer([
    'container.build_hash' => '3uc018A',
    'container.build_id' => '3cdbac00',
    'container.build_time' => 1682319456,
], __DIR__.\DIRECTORY_SEPARATOR.'Container3uc018A');
