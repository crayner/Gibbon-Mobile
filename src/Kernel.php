<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));

        if (! $container->hasParameter('cookie_lifetime'))
            $container->setParameter('cookie_lifetime', 1200);
        if (! $container->hasParameter('google_client_id'))
            $container->setParameter('google_client_id', null);
        if (! $container->hasParameter('google_secret'))
            $container->setParameter('google_secret', null);
        if (! $container->hasParameter('session_name'))
            $container->setParameter('session_name', 'set_by_kernel');
        if (! $container->hasParameter('locale'))
            $container->setParameter('locale', 'en');
        if (! $container->hasParameter('security.hierarchy.roles'))
            $container->setParameter('security.hierarchy.roles', []);
        if (! $container->hasParameter('mailer_transport'))
            $container->setParameter('mailer_transport', null);
        if (! $container->hasParameter('mailer_host'))
            $container->setParameter('mailer_host', null);
        if (! $container->hasParameter('mailer_port'))
            $container->setParameter('mailer_port', null);
        if (! $container->hasParameter('mailer_user'))
            $container->setParameter('mailer_user', null);
        if (! $container->hasParameter('mailer_password'))
            $container->setParameter('mailer_password', null);
        if (! $container->hasParameter('gibbon_document_root'))
            $container->setParameter('gibbon_document_root', '');
        if (! $container->hasParameter('db_prefix'))
            $container->setParameter('db_prefix', 'gibbon');

        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }
}
