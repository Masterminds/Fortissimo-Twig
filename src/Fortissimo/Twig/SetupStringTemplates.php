<?php
/**
 * @file
 * A Fortissimo Command to setup Twig through Strings to use for output generation.
 */

namespace Fortissimo\Twig;

/**
 * Setup Twig string templates and add the enviornment to the context.
 * 
 * This command setups up Twig Stings templates and makes it available on 
 * the Context.
 *
 * For more information on the API visit http://twig.sensiolabs.org/doc/api.html
 */
class SetupStringTemplates extends \Fortissimo\Command\Base {
  public function expects() {
    return $this->description('Setup a Twig enviornment that uses strings for templates.')
      ->usesParam('debug', 'Whether the Twig enviornment should use debug mode (defaults to FALSE).')
        ->withFilter('boolean')
        ->whichHasDefault(FALSE)
      ->usesParam('charset', 'The charset used by the templates (defaults to utf-8).')
        ->withFilter('string')
      ->usesParam('base_template_class', 'The base template class to use for generated templates (defaults to Twig_Template).')
      ->usesParam('cache', 'An absolute path where to store the compiled templates, or FALSE to disable caching (defaults to FALSE).')
      ->usesParam('auto_reload', 'If Twig should recompile the templates when the source changes. If not specified it is determinded from the debug value.')
      ->usesParam('strict_variables', 'Whether Twig will silently ignore invalid variables. When set to TRUE exectptions will be thrown. Defautls to FALSE.')
        ->withFilter('boolean')
        ->whichHasDefault(FALSE)
      ->usesParam('autoescape', 'If auto-escaping should be enabled by default in templates (defaults to TRUE).')
        ->withFilter('boolean')
        ->whichHasDefault(TRUE)
      ->usesParam('optimizations', 'A flag that indicates which optimizations to apply. Defaults to -1 (all optimizations). Set to 0 for no optimizations.')
      ->andReturns('Twig_Environment. A Twig enviornment setup and ready to be used.')
    ;
  }

  public function doCommand() {
    $loader = new \Twig_Loader_String();

    $settings = array(
      'debug' => $this->param('debug', FALSE),
      'charset' => $this->param('charset', 'utf-8'),
      'base_template_class' => $this->param('base_template_class', 'Twig_Template'),
      'strict_variables' => $this->param('strict_variables', FALSE),
      'autoescape' => $this->param('autoescape', TRUE),
      'optimizations' => $this->param('optimizations', -1),
    );

    $auto_reload = $this->param('auto_reload', NULL);
    if (!is_null($auto_reload)) {
      $settings['auto_reload'] = $auto_reload;
    }

    $enviornment = new \Twig_Environment($loader, $settings);

    return $enviornment;
  }
}