<?php

namespace Drupal\admin_toolbar_tools\Controller;

 
 
 
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\CronInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Menu\ContextualLinkManager;
use Drupal\Core\Menu\LocalActionManager;
use Drupal\Core\Menu\LocalTaskManager;
use Drupal\Core\Menu\MenuLinkManager;
=======
use Drupal\Component\Datetime\TimeInterface;
=======
use Drupal\Component\Datetime\Time;
=======
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\CronInterface;
use Drupal\Core\Menu\ContextualLinkManagerInterface;
use Drupal\Core\Menu\LocalActionManagerInterface;
use Drupal\Core\Menu\LocalTaskManagerInterface;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\Plugin\CachedDiscoveryClearerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
 
 
use Drupal\Core\PhpStorage\PhpStorageFactory;
=======
=======
use Drupal\Core\PhpStorage\PhpStorageFactory;

/**
 * Class ToolbarController
 * @package Drupal\admin_toolbar_tools\Controller
 */
class ToolbarController extends ControllerBase {

  /**
   * The cron service.
   *
   * @var $cron \Drupal\Core\CronInterface
   */
  protected $cron;
 
  protected $menuLinkManager;
  protected $contextualLinkManager;
  protected $localTaskLinkManager;
=======

  /**
   * A menu link manager instance.
   *
   * @var \Drupal\Core\Menu\MenuLinkManagerInterface
   */
  protected $menuLinkManager;

  /**
   * A context link manager instance.
   *
   * @var \Drupal\Core\Menu\ContextualLinkManagerInterface
   */
  protected $contextualLinkManager;

  /**
   * A local task manager instance.
   *
   * @var \Drupal\Core\Menu\LocalTaskManagerInterface
   */
  protected $localTaskLinkManager;

  /**
   * A local action manager instance.
   *
   * @var \Drupal\Core\Menu\LocalActionManagerInterface
   */
  protected $localActionLinkManager;
  protected $cacheRender;

  /**
 
   * Constructs a CronController object.
   *
   * @param \Drupal\Core\CronInterface $cron
   *   The cron service.
   */
  public function __construct(CronInterface $cron,
                              MenuLinkManager $menuLinkManager,
                              ContextualLinkManager $contextualLinkManager,
                              LocalTaskManager $localTaskLinkManager,
                              LocalActionManager $localActionLinkManager,
                              CacheBackendInterface $cacheRender) {
=======
   * A date time instance.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * A request stack symfony instance.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * A plugin cache clear instance.
   *
   * @var \Drupal\Core\Plugin\CachedDiscoveryClearerInterface
   */
  protected $pluginCacheClearer;

  /**
   * Constructs a ToolbarController object.
   *
   * @param \Drupal\Core\CronInterface $cron
   *   A cron instance.
   * @param \Drupal\Core\Menu\MenuLinkManagerInterface $menuLinkManager
   *   A menu link manager instance.
   * @param \Drupal\Core\Menu\ContextualLinkManagerInterface $contextualLinkManager
   *   A context link manager instance.
   * @param \Drupal\Core\Menu\LocalTaskManagerInterface $localTaskLinkManager
   *   A local task manager instance.
   * @param \Drupal\Core\Menu\LocalActionManagerInterface $localActionLinkManager
   *   A local action manager instance.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cacheRender
   *   A cache backend interface instance.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   A date time instance.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   A request stack symfony instance.
   * @param \Drupal\Core\Plugin\CachedDiscoveryClearerInterface $plugin_cache_clearer
   *   A plugin cache clear instance.
   */
  public function __construct(CronInterface $cron,
                              MenuLinkManagerInterface $menuLinkManager,
                              ContextualLinkManagerInterface $contextualLinkManager,
                              LocalTaskManagerInterface $localTaskLinkManager,
                              LocalActionManagerInterface $localActionLinkManager,
                              CacheBackendInterface $cacheRender,
                              TimeInterface $time,
                              RequestStack $request_stack,
                              CachedDiscoveryClearerInterface $plugin_cache_clearer) {
    $this->cron = $cron;
    $this->menuLinkManager = $menuLinkManager;
    $this->contextualLinkManager = $contextualLinkManager;
    $this->localTaskLinkManager = $localTaskLinkManager;
    $this->localActionLinkManager = $localActionLinkManager;
    $this->cacheRender = $cacheRender;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cron'),
      $container->get('plugin.manager.menu.link'),
      $container->get('plugin.manager.menu.contextual_link'),
      $container->get('plugin.manager.menu.local_task'),
      $container->get('plugin.manager.menu.local_action'),
      $container->get('cache.render')
    );
  }

  // Reload the previous page.
  public function reload_page() {
    $request = \Drupal::request();
    if($request->server->get('HTTP_REFERER')) {
      return $request->server->get('HTTP_REFERER');
    }
    else{
      return '/';
    }
  }

  // Flushes all caches.
  public function flushAll() {
    drupal_flush_all_caches();
    drupal_set_message($this->t('All caches cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Flushes css and javascript caches.
  public function flush_js_css() {
    \Drupal::state()
      ->set('system.css_js_query_string', base_convert(REQUEST_TIME, 10, 36));
    drupal_set_message($this->t('CSS and JavaScript cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Flushes plugins caches.
  public function flush_plugins() {
    \Drupal::service('plugin.cache_clearer')->clearCachedDefinitions();
    drupal_set_message($this->t('Plugins cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Resets all static caches.
  public function flush_static() {
    drupal_static_reset();
    drupal_set_message($this->t('Static cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Clears all cached menu data.
  public function flush_menu() {
    menu_cache_clear_all();
    $this->menuLinkManager->rebuild();
    $this->contextualLinkManager->clearCachedDefinitions();
    $this->localTaskLinkManager->clearCachedDefinitions();
    $this->localActionLinkManager->clearCachedDefinitions();
    drupal_set_message($this->t('Routing and links cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

  // Links to drupal.org home page.
  public function drupal_org() {
    $response = new RedirectResponse("https://www.drupal.org");
    $response->send();
    return $response;
  }

  // Displays the administration link Development.
  public function development() {
    return new RedirectResponse('/admin/structure/menu/');
  }

  // Access to Drupal 8 changes (list changes of the different versions of drupal core).
  public function list_changes() {
    $response = new RedirectResponse("https://www.drupal.org/list-changes");
    $response->send();
    return $response;
  }

  // Adds a link to the Drupal 8 documentation.
  public function documentation() {
    $response = new RedirectResponse("https://api.drupal.org/api/drupal/8");
    $response->send();
    return $response;
  }

 
=======
  /**
   * Clears the twig cache.
   */
  public function flushTwig() {
    // @todo Update once Drupal 8.6 will be released.
    // @see https://www.drupal.org/node/2908461
    PhpStorageFactory::get('twig')->deleteAll();
    drupal_set_message($this->t('Twig cache cleared.'));
    return new RedirectResponse($this->reloadPage());
  }

  /**
   * Run the cron.
   */
  public function runCron() {
    $this->cron->run();
    drupal_set_message($this->t('Cron ran successfully.'));
    return new RedirectResponse($this->reload_page());
  }

  public function cacheRender() {
    $this->cacheRender->invalidateAll();
    drupal_set_message($this->t('Render cache cleared.'));
    return new RedirectResponse($this->reload_page());
  }

}
