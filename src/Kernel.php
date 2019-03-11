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

        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = realpath($this->getProjectDir().'/config');

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');

        if (!realpath($confDir . '/packages/gibbon_responsive.yaml'))
            $this->temporaryParameters($container);

        ini_set('date.timezone', $container->getParameter('timezone'));
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }

    /**
     * temporaryParameters
     * @param ContainerBuilder $container
     */
    private function temporaryParameters(ContainerBuilder $container)
    {
        $container->setParameter('session_name', 'gibbon_responsive');
        $container->setParameter('locale', 'en_GB');
        $container->setParameter('db_driver', 'pdo_mysql');
        $container->setParameter('db_host', '127.0.0.1');
        $container->setParameter('db_port', 3306);
        $container->setParameter('db_name', null);
        $container->setParameter('db_charset', null);
        $container->setParameter('db_user', null);
        $container->setParameter('db_pass', null);
        $container->setParameter('db_prefix', 'mobile');
        $container->setParameter('db_server_version', '5.7');
        $container->setParameter('mailer_transport', null);
        $container->setParameter('mailer_host', null);
        $container->setParameter('mailer_user', null);
        $container->setParameter('mailer_password', null);
        $container->setParameter('mailer_port', null);
        $container->setParameter('mailer_spool', null);
        $container->setParameter('mailer_encryption', null);
        $container->setParameter('mailer_auth_mode', null);
        $container->setParameter('cookie_lifetime', 0);
        $container->setParameter('security.hierarchy.roles', []);
        $container->setParameter('gibbon_document_root', '');
        $container->setParameter('gibbon_host_url', '');
        $container->setParameter('google_client_id', '');
        $container->setParameter('timezone', 'UTC');
    }
}
