<?php
/**
 * @file
 * A Fortissimo Command to render a Twig template.
 */

namespace Fortissimo\Twig;

/**
 * This command renders a Twig template.
 *
 * For more information on the API visit http://twig.sensiolabs.org/doc/api.html
 */
class Render extends \Fortissimo\Command\Base {
  public function expects() {
    return $this->description('Setup a Twig enviornment that uses strings for templates.')
      ->usesParam('enviornment', 'A twig enviornment to render the template.')
        ->whichIsRequired()
      ->usesParam('template', 'The template to render. This can be a path to a template file for filesystem templates or a string for a template as a string.')
        ->withFilter('string')
        ->whichIsRequired()
      ->usesParam('variables', 'The variables to use in the template as an array.')
      ->usesParam('print', 'Whether to print the template or return the rendered output (defaults to TRUE).')
        ->withFilter('boolean')
        ->whichHasDefault(TRUE)
      ->andReturns('If print is set to TRUE nothing is returned. If set to FALSE a string with the rendered template is returned.')
    ;
  }

  public function doCommand() {
    $enviornment = $this->param('enviornment');
    $file = $this->param('template');
    $variables = $this->param('variables', array());
    $print = $this->param('print');

    $template = $enviornment->loadTemplate($file);

    $output = $template->render($variables);

    if ($print) {
      print $output;
    }
    else {
      return $output;
    }

  }
}